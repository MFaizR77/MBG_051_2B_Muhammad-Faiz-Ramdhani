@extends('gudang.dashboard') 
<!-- Menggunakan layout utama dari dashboard gudang -->

@section('content')
<!-- Awal dari bagian konten utama halaman -->

<div class="container my-4">
    <!-- Container utama dengan margin atas dan bawah -->

    <div class="d-flex align-items-center justify-content-between mb-4">
        <!-- Header halaman: judul dan tombol kembali -->
        <div class="d-flex align-items-center">
            <i class="bi bi-pencil-square text-primary fs-3 me-2"></i>
            <!-- Ikon edit bahan -->
            <h3 class="fw-semibold mb-0">Edit Stok Bahan</h3>
            <!-- Judul halaman -->
        </div>
        <a href="{{ route('gudang.bahan.index') }}" class="btn btn-outline-secondary">
            <!-- Tombol kembali ke halaman daftar bahan -->
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    @if ($errors->any())
        <!-- Menampilkan pesan error validasi jika ada -->
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i> Terjadi kesalahan:
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0 rounded-3">
        <!-- Card utama tempat form edit stok -->
        <div class="card-header bg-primary bg-opacity-10 border-bottom-0 py-3">
            <!-- Header card dengan warna lembut -->
            <h5 class="mb-0 text-primary fw-semibold">
                <i class="bi bi-box-seam me-2"></i> {{ $bahan->nama }}
            </h5>
            <!-- Menampilkan nama bahan yang sedang diedit -->
        </div>

        <div class="card-body">
            <!-- Isi dari card -->
            <form action="{{ route('gudang.bahan.update', $bahan->id) }}" method="POST" class="needs-validation" novalidate>
                <!-- Form untuk mengirim perubahan stok -->
                @csrf
                <!-- Token keamanan Laravel -->
                @method('PUT')
                <!-- Metode PUT digunakan untuk update data -->

                <div class="mb-3">
                    <!-- Input jumlah stok bahan -->
                    <label for="jumlah" class="form-label fw-semibold">Jumlah Stok</label>
                    <input type="number" id="jumlah" name="jumlah" class="form-control form-control-lg"
                           value="{{ old('jumlah', $bahan->jumlah) }}" min="0" required>
                    <div class="form-text text-muted">Masukkan jumlah stok bahan yang tersedia.</div>
                </div>

                <div class="text-end mt-4">
                    <!-- Tombol aksi simpan -->
                    <button type="submit" class="btn btn-primary px-4 py-2 fw-semibold"
                            onclick="return confirm('Yakin ingin menyimpan perubahan stok bahan ini?')">
                        <i class="bi bi-save2 me-2"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

