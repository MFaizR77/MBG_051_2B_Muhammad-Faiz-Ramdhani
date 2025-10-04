<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BahanBakuController extends Controller
{
    /**
     * Menampilkan form untuk menambah bahan baru.
     */
    public function create()
    {
        // Tampilkan view form input bahan baru
        return view('gudang.bahan.create');
    }

    /**
     * Menyimpan data bahan baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi input agar semua data sesuai aturan
        $request->validate([
            'nama' => 'required|string|max:120',
            'kategori' => 'required|string|max:60',
            'jumlah' => 'required|integer|min:0',
            'satuan' => 'required|string|max:20',
            'tanggal_masuk' => 'required|date|before_or_equal:tanggal_kadaluarsa',
            'tanggal_kadaluarsa' => 'required|date|after:tanggal_masuk',
        ], [
            // Pesan error kustom
            'jumlah.min' => 'Jumlah tidak boleh negatif.',
            'tanggal_kadaluarsa.after' => 'Tanggal kadaluarsa harus setelah tanggal masuk.',
        ]);

        // Ambil data penting dari request
        $jumlah = $request->jumlah;
        $tglKadaluarsa = Carbon::parse($request->tanggal_kadaluarsa);
        $today = Carbon::today();

        // Tentukan status bahan berdasarkan stok & tanggal
        if ($jumlah == 0) {
            $status = 'habis';
        } elseif ($today->greaterThanOrEqualTo($tglKadaluarsa)) {
            $status = 'kadaluarsa';
        } elseif ($today->lessThan($tglKadaluarsa) && $today->diffInDays($tglKadaluarsa) <= 3) {
            $status = 'segera_kadaluarsa';
        } else {
            $status = 'tersedia';
        }

        // Simpan data bahan baru ke database
        BahanBaku::create([
            'nama' => $request->nama,
            'kategori' => $request->kategori,
            'jumlah' => $jumlah,
            'satuan' => $request->satuan,
            'tanggal_masuk' => $request->tanggal_masuk,
            'tanggal_kadaluarsa' => $request->tanggal_kadaluarsa,
            'status' => $status,
        ]);

        // Kembali ke halaman index dengan pesan sukses
        return redirect()->route('gudang.bahan.index')
            ->with('success', 'Bahan baku berhasil ditambahkan!');
    }

    /**
     * Menampilkan daftar seluruh bahan.
     */
    public function index()
    {
        // Ambil semua data bahan dari database
        $bahan = BahanBaku::all();

        // Tampilkan halaman daftar bahan
        return view('gudang.bahan.index', compact('bahan'));
    }

    /**
     * Menampilkan form edit stok bahan tertentu.
     */
    public function edit($id)
    {
        // Cari bahan berdasarkan ID
        $bahan = BahanBaku::findOrFail($id);

        // Tampilkan form edit bahan
        return view('gudang.bahan.edit', compact('bahan'));
    }

    /**
     * Memperbarui jumlah stok bahan.
     */
    public function update(Request $request, $id)
    {
        // Cari bahan berdasarkan ID
        $bahan = BahanBaku::findOrFail($id);

        // Validasi input jumlah stok
        $request->validate([
            'jumlah' => 'required|integer|min:0',
        ], [
            'jumlah.min' => 'Jumlah stok tidak boleh kurang dari 0.',
        ]);

        // Update jumlah stok bahan
        $bahan->jumlah = $request->jumlah;

        // Simpan perubahan ke database
        $bahan->save();

        // Kembali ke halaman daftar bahan dengan notifikasi sukses
        return redirect()->route('gudang.bahan.index')
            ->with('success', 'Stok bahan berhasil diperbarui!');
    }

    /**
     * Menampilkan halaman konfirmasi penghapusan bahan.
     */
    public function confirmDelete($id)
    {
        // Ambil data bahan berdasarkan ID
        $bahan = BahanBaku::findOrFail($id);

        // Tampilkan halaman konfirmasi penghapusan
        return view('gudang.bahan.delete', compact('bahan'));
    }

    /**
     * Menghapus bahan dari database.
     */
    public function destroy($id)
    {
        // Ambil data bahan berdasarkan ID
        $bahan = BahanBaku::findOrFail($id);

        // Cegah penghapusan jika bahan belum kadaluarsa
        if ($bahan->status !== 'kadaluarsa') {
            return redirect()->route('gudang.bahan.index')
                ->with('error', 'Bahan tidak bisa dihapus karena statusnya bukan kadaluarsa.');
        }

        // Hapus data bahan dari database
        $bahan->delete();

        // Kembali ke halaman index dengan pesan sukses
        return redirect()->route('gudang.bahan.index')
            ->with('success', 'Bahan kadaluarsa berhasil dihapus!');
    }
}
