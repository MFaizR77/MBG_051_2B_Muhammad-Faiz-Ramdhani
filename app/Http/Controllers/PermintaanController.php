<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BahanBaku;
use App\Models\Permintaan;
use App\Models\PermintaanDetail;

class PermintaanController extends Controller
{
    /**
     * Menampilkan form untuk membuat permintaan bahan oleh dapur.
     */
    public function create()
    {
        // Ambil bahan yang stoknya masih tersedia dan belum kadaluarsa
        $bahanTersedia = BahanBaku::where('jumlah', '>', 0)
            ->where('status', '!=', 'kadaluarsa')
            ->get();

        // Kirim data bahan ke view form permintaan
        return view('dapur.permintaan.create', compact('bahanTersedia'));
    }

    /**
     * Menyimpan permintaan bahan baru dari dapur ke database.
     */
    public function store(Request $request)
    {
        // Validasi input permintaan
        $request->validate([
            'tgl_masak' => 'required|date',
            'menu_makan' => 'required|string|max:255',
            'jumlah_porsi' => 'required|integer|min:1',
            'bahan_id' => 'required|array',
            'bahan_id.*' => 'exists:bahan_baku,id',
            'jumlah_diminta' => 'required|array',
            'jumlah_diminta.*' => 'required|integer|min:1',
        ]);

        // Ambil ID pengguna yang sedang login
        $pemohonId = session('user_id');

        // Pastikan pengguna sudah login
        if (!$pemohonId) {
            return redirect()->route('login')->withErrors('Anda harus login sebagai petugas dapur.');
        }

        // Simpan data utama permintaan
        $permintaan = Permintaan::create([
            'pemohon_id' => $pemohonId,
            'tgl_masak' => $request->tgl_masak,
            'menu_makan' => $request->menu_makan,
            'jumlah_porsi' => $request->jumlah_porsi,
            'status' => 'menunggu', // default status
        ]);

        // Simpan detail permintaan (bahan + jumlah)
        foreach ($request->bahan_id as $index => $bahanId) {
            PermintaanDetail::create([
                'permintaan_id' => $permintaan->id,
                'bahan_id' => $bahanId,
                'jumlah_diminta' => $request->jumlah_diminta[$index],
            ]);
        }

        // Redirect ke halaman status permintaan dengan notifikasi sukses
        return redirect()->route('dapur.permintaan.status')
            ->with('success', 'Permintaan berhasil dikirim!');
    }

    /**
     * Menampilkan daftar permintaan yang menunggu persetujuan di gudang.
     */
    public function indexGudang()
    {
        // Ambil semua permintaan 'menunggu' lengkap dengan data pemohon dan bahan
        $permintaanList = Permintaan::with(['pemohon', 'details.bahan'])
            ->where('status', 'menunggu')
            ->orderBy('created_at', 'desc')
            ->get();

        // Kirim data ke halaman gudang untuk ditampilkan
        return view('gudang.permintaan.index', compact('permintaanList'));
    }

    /**
     * Menampilkan daftar permintaan milik user dapur yang sedang login.
     */
    public function status()
    {
        // Ambil ID user dari sesi login
        $pemohonId = session('user_id');

        // Ambil semua permintaan milik user tersebut
        $permintaan = Permintaan::where('pemohon_id', $pemohonId)
            ->orderBy('created_at', 'desc')
            ->get();

        // Tampilkan di halaman status permintaan
        return view('dapur.permintaan.status', compact('permintaan'));
    }

    /**
     * Menampilkan detail lengkap permintaan milik user yang login.
     */
    public function show($id)
    {
        // Ambil data permintaan beserta bahan-bahannya
        $permintaan = Permintaan::with('details.bahan')
            ->where('pemohon_id', session('user_id')) // hanya milik sendiri
            ->findOrFail($id);

        // Kirim ke halaman detail permintaan
        return view('dapur.permintaan.detail', compact('permintaan'));
    }

    /**
     * Menyetujui permintaan bahan oleh pihak gudang.
     */
    public function approve($id)
    {
        // Ambil permintaan beserta detail bahan
        $permintaan = Permintaan::with('details.bahan')->findOrFail($id);

        // Cek apakah stok mencukupi untuk semua bahan yang diminta
        foreach ($permintaan->details as $detail) {
            $bahan = $detail->bahan;
            if ($bahan->jumlah < $detail->jumlah_diminta) {
                // Jika stok tidak cukup, batalkan
                return back()->withErrors("Stok '{$bahan->nama}' tidak mencukupi untuk permintaan ini.");
            }
        }

        // Kurangi stok bahan sesuai jumlah permintaan
        foreach ($permintaan->details as $detail) {
            $bahan = $detail->bahan;
            $bahan->jumlah -= $detail->jumlah_diminta;

            // Update status bahan setelah stok berubah
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

        // Update status permintaan menjadi 'disetujui'
        $permintaan->status = 'disetujui';
        $permintaan->save();

        // Redirect dengan pesan sukses
        return redirect()->route('gudang.permintaan.index')
            ->with('success', 'Permintaan disetujui dan stok diperbarui.');
    }

    /**
     * Menolak permintaan bahan dari dapur.
     */
    public function reject(Request $request, $id)
    {
        // Validasi alasan penolakan (opsional)
        $request->validate([
            'alasan' => 'nullable|string|max:255',
        ]);

        // Temukan permintaan dan ubah statusnya
        $permintaan = Permintaan::findOrFail($id);
        $permintaan->status = 'ditolak';
        $permintaan->save();

        // Kembali ke halaman gudang dengan pesan sukses
        return redirect()->route('gudang.permintaan.index')
            ->with('success', 'Permintaan berhasil ditolak.');
    }
}
