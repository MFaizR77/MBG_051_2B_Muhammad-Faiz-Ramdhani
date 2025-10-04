<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BahanBaku;
use App\Models\Permintaan;
use App\Models\PermintaanDetail;

class PermintaanController extends Controller
{
    public function create()
    {
        // Ambil bahan yang tersedia (stok > 0 dan tidak kadaluarsa)
        $bahanTersedia = BahanBaku::where('jumlah', '>', 0)
            ->where('status', '!=', 'kadaluarsa')
            ->get();

        return view('dapur.permintaan.create', compact('bahanTersedia'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tgl_masak' => 'required|date',
            'menu_makan' => 'required|string|max:255',
            'jumlah_porsi' => 'required|integer|min:1',
            'bahan_id' => 'required|array',
            'bahan_id.*' => 'exists:bahan_baku,id',
            'jumlah_diminta' => 'required|array',
            'jumlah_diminta.*' => 'required|integer|min:1',
        ]);

        $pemohonId = session('user_id');

        if (!$pemohonId) {
            return redirect()->route('login')->withErrors('Anda harus login sebagai petugas dapur.');
        }



        $permintaan = Permintaan::create([
            'pemohon_id' => $pemohonId,
            'tgl_masak' => $request->tgl_masak,
            'menu_makan' => $request->menu_makan,
            'jumlah_porsi' => $request->jumlah_porsi,
            'status' => 'menunggu',
        ]);

        // Simpan detail permintaan
        foreach ($request->bahan_id as $index => $bahanId) {
            PermintaanDetail::create([
                'permintaan_id' => $permintaan->id,
                'bahan_id' => $bahanId,
                'jumlah_diminta' => $request->jumlah_diminta[$index],
            ]);
        }

        return redirect()->route('dapur.permintaan.status')->with('success', 'Permintaan berhasil dikirim!');
    }

    public function indexGudang()
    {
        // Ambil semua permintaan dengan status 'menunggu', urut terbaru
        $permintaanList = Permintaan::with(['pemohon', 'details.bahan'])->where('status','menunggu') 
            ->orderBy('created_at', 'desc')
            ->get();

        return view('gudang.permintaan.index', compact('permintaanList'));
    }

    public function status()
    {
        // Ambil permintaan milik user yang sedang login
        $pemohonId = session('user_id');

        $permintaan = Permintaan::where('pemohon_id', $pemohonId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dapur.permintaan.status', compact('permintaan'));
    }

    public function show($id)
    {
        $permintaan = Permintaan::with('details.bahan')
            ->where('pemohon_id', session('user_id')) // pastikan hanya lihat milik sendiri
            ->findOrFail($id);

        return view('dapur.permintaan.detail', compact('permintaan'));
    }

    public function approve($id)
    {
        $permintaan = Permintaan::with(relations: 'details.bahan')->findOrFail($id);

        // Cek stok cukup?
        foreach ($permintaan->details as $detail) {
            $bahan = $detail->bahan;
            if ($bahan->jumlah < $detail->jumlah_diminta) {
                return back()->withErrors("Stok '{$bahan->nama}' tidak mencukupi untuk permintaan ini.");
            }
        }

        // Kurangi stok
        foreach ($permintaan->details as $detail) {
            $bahan = $detail->bahan;
            $bahan->jumlah -= $detail->jumlah_diminta;

            // Update status bahan
            if ($bahan->jumlah == 0) {
                $bahan->status = 'habis';
            } elseif (now()->greaterThanOrEqualTo($bahan->tanggal_kadaluarsa)) {
                $bahan->status = 'kadaluarsa';
            } elseif (now()->addDays(3)->greaterThanOrEqualTo($bahan->tanggal_kadaluarsa)) {
                $bahan->status = 'segera_kadaluarsa';
            } else {
                $bahan->status = 'tersedia';
            }

            $bahan->save();
        }

        // Update status permintaan
        $permintaan->status = 'disetujui';
        $permintaan->save();

        return redirect()->route('gudang.permintaan.index')
            ->with('success', 'Permintaan disetujui dan stok diperbarui.');
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'alasan' => 'nullable|string|max:255',
        ]);

        $permintaan = Permintaan::findOrFail($id);
        $permintaan->status = 'ditolak';
        $permintaan->save();

        return redirect()->route('gudang.permintaan.index')
            ->with('success', 'Permintaan berhasil ditolak.');
    }
}