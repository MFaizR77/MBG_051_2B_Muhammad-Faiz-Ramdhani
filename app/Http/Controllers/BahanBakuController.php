<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BahanBakuController extends Controller
{
    public function create()
    {
        return view('gudang.bahan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:120',
            'kategori' => 'required|string|max:60',
            'jumlah' => 'required|integer|min:0',
            'satuan' => 'required|string|max:20',
            'tanggal_masuk' => 'required|date|before_or_equal:tanggal_kadaluarsa',
            'tanggal_kadaluarsa' => 'required|date|after:tanggal_masuk',
        ], [
            'jumlah.min' => 'Jumlah tidak boleh negatif.',
            'tanggal_kadaluarsa.after' => 'Tanggal kadaluarsa harus setelah tanggal masuk.',
        ]);

        $jumlah = $request->jumlah;
        $tglKadaluarsa = Carbon::parse($request->tanggal_kadaluarsa);
        $today = Carbon::today();

        if ($jumlah == 0) {
            $status = 'habis';
        } elseif ($today->greaterThanOrEqualTo($tglKadaluarsa)) {
            $status = 'kadaluarsa';
        } elseif ($tglKadaluarsa->diffInDays($today) <= 3) {
            $status = 'segera_kadaluarsa';
        } else {
            $status = 'tersedia';
        }

        BahanBaku::create([
            'nama' => $request->nama,
            'kategori' => $request->kategori,
            'jumlah' => $jumlah,
            'satuan' => $request->satuan,
            'tanggal_masuk' => $request->tanggal_masuk,
            'tanggal_kadaluarsa' => $request->tanggal_kadaluarsa,
            'status' => $status,
        ]);

        return redirect()->route('gudang.bahan.index')
            ->with('success', 'Bahan baku berhasil ditambahkan!');
    }

    public function index()
    {
        $bahan = BahanBaku::all(); 
        return view('gudang.bahan.index', compact('bahan'));
    }

    public function edit($id)
    {
        $bahan = BahanBaku::findOrFail($id);
        return view('gudang.bahan.edit', compact('bahan'));
    }

    public function update(Request $request, $id)
    {
        $bahan = BahanBaku::findOrFail($id);

        $request->validate([
            'jumlah' => 'required|integer|min:0',
        ], [
            'jumlah.min' => 'Jumlah stok tidak boleh kurang dari 0.',
        ]);

        $bahan->jumlah = $request->jumlah;

        $bahan->save();

        return redirect()->route('gudang.bahan.index')
            ->with('success', 'Stok bahan berhasil diperbarui!');
    }

    public function confirmDelete($id)
    {
        $bahan = BahanBaku::findOrFail($id);
        return view('gudang.bahan.delete', compact('bahan'));
    }

    public function destroy($id)
    {
        $bahan = BahanBaku::findOrFail($id);

        // Cek status bahan
        if ($bahan->status !== 'kadaluarsa') {
            return redirect()->route('gudang.bahan.index')
                ->with('error', 'Bahan tidak bisa dihapus karena statusnya bukan kadaluarsa.');
        }

        $bahan->delete();

        return redirect()->route('gudang.bahan.index')
            ->with('success', 'Bahan kadaluarsa berhasil dihapus!');
    }


}