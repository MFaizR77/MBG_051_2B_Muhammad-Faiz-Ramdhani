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
        // Validasi input
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

        // Hitung status awal
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

        // Simpan ke database
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
        $bahan = BahanBaku::all(); // atau pakai orderBy jika mau
        return view('gudang.bahan.index', compact('bahan'));
    }
}