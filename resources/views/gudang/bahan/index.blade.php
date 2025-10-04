@extends('gudang.dashboard')
<!-- Menggunakan layout utama dari dashboard gudang -->

@section('content')
<!-- Awal dari bagian konten utama halaman -->

<div class="container my-4">
    <!-- Container utama untuk membungkus seluruh isi halaman dengan margin atas-bawah -->

    <div class="d-flex align-items-center justify-content-between mb-4">
        <!-- Baris header: berisi judul halaman dan tombol tambah bahan -->
        <div class="d-flex align-items-center">
            <i class="bi bi-box-seam fs-3 text-primary me-2"></i>
            <!-- Ikon gudang untuk memperindah tampilan judul -->
            <h3 class="fw-semibold mb-0">Daftar Bahan Baku</h3>
            <!-- Judul halaman -->
        </div>
        <a href="{{ route('gudang.bahan.create') }}" class="btn btn-primary shadow-sm">
            <!-- Tombol menuju halaman tambah bahan baru -->
            <i class="bi bi-plus-circle me-1"></i> Tambah Bahan
        </a>
    </div>

    @if(session('success'))
        <!-- Menampilkan pesan sukses setelah operasi berhasil (misalnya tambah atau update) -->
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="table-responsive shadow-sm rounded">
        <!-- Membungkus tabel agar bisa di-scroll horizontal di layar kecil -->
        <table class="table align-middle table-hover table-striped mb-0">
            <!-- Tabel utama berisi daftar bahan baku -->
            <thead class="table-dark">
                <!-- Header tabel dengan latar gelap -->
                <tr>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Jumlah</th>
                    <th>Satuan</th>
                    <th>Tgl Masuk</th>
                    <th>Tgl Kadaluarsa</th>
                    <th>Status</th>
                    <th class="text-center">Aksi</th>
                    <!-- Kolom aksi berisi tombol edit dan hapus -->
                </tr>
            </thead>
            <tbody>
                <!-- Isi tabel -->
                @forelse($bahan as $item)
                    <!-- Loop menampilkan setiap data bahan baku -->
                    <tr>
                        <td class="fw-semibold">{{ $item->nama }}</td>
                        <!-- Nama bahan -->
                        <td>{{ $item->kategori }}</td>
                        <!-- Kategori bahan -->
                        <td>{{ $item->jumlah }}</td>
                        <!-- Jumlah stok bahan -->
                        <td>{{ $item->satuan }}</td>
                        <!-- Satuan bahan (kg, liter, dll) -->
                        <td>{{ $item->tanggal_masuk->format('d-m-Y') }}</td>
                        <!-- Tanggal bahan masuk gudang -->
                        <td>{{ $item->tanggal_kadaluarsa->format('d-m-Y') }}</td>
                        <!-- Tanggal kadaluarsa bahan -->
                        <td>
                            <!-- Status bahan ditandai dengan badge warna berbeda -->
                            @switch($item->status)
                                @case('habis')
                                    <span class="badge bg-secondary px-3 py-2">Habis</span>
                                    @break
                                @case('kadaluarsa')
                                    <span class="badge bg-danger px-3 py-2">Kadaluarsa</span>
                                    @break
                                @case('segera_kadaluarsa')
                                    <span class="badge bg-warning text-dark px-3 py-2">Segera Kadaluarsa</span>
                                    @break
                                @default
                                    <span class="badge bg-success px-3 py-2">Tersedia</span>
                            @endswitch
                        </td>
                        <td class="text-center">
                            <!-- Tombol aksi edit dan hapus -->
                            <a href="{{ route('gudang.bahan.edit', $item->id) }}" class="btn btn-sm btn-outline-warning me-2">
                                <!-- Tombol edit stok bahan -->
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <a href="{{ route('gudang.bahan.confirmDelete', $item->id) }}" class="btn btn-sm btn-outline-danger">
                                <!-- Tombol hapus bahan -->
                                <i class="bi bi-trash3"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <!-- Jika tidak ada data bahan, tampilkan pesan kosong -->
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">
                            <i class="bi bi-exclamation-circle me-1"></i> Belum ada data bahan baku
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

