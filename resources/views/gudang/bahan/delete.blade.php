@extends('gudang.dashboard') 
<!-- Menggunakan layout utama dari dashboard gudang -->

@section('content')
<!-- Awal dari konten utama halaman -->

<div class="container my-4">
    <!-- Container utama untuk membungkus seluruh isi halaman -->

    <div class="d-flex align-items-center justify-content-between mb-4">
        <!-- Header halaman dengan judul dan tombol kembali -->
        <div class="d-flex align-items-center">
            <i class="bi bi-exclamation-triangle-fill text-warning fs-3 me-2"></i>
            <h3 class="fw-semibold mb-0">Konfirmasi Hapus Bahan Baku</h3>
        </div>
        <a href="{{ route('gudang.bahan.index') }}" class="btn btn-outline-secondary shadow-sm">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="alert alert-warning shadow-sm">
        <!-- Peringatan utama untuk pengguna sebelum menghapus data -->
        <strong><i class="bi bi-exclamation-circle me-2"></i>Perhatian!</strong> 
        Anda akan menghapus data bahan berikut secara permanen.
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <!-- Card utama untuk menampilkan detail bahan baku -->
        <div class="card-body">
            <!-- Isi detail bahan baku -->

            <div class="row mb-3">
                <!-- Baris 1: informasi dasar bahan -->
                <div class="col-md-6">
                    <p class="mb-1"><strong>Nama:</strong></p>
                    <p class="text-muted">{{ $bahan->nama }}</p>
                </div>
                <div class="col-md-6">
                    <p class="mb-1"><strong>Kategori:</strong></p>
                    <p class="text-muted">{{ $bahan->kategori }}</p>
                </div>
            </div>

            <div class="row mb-3">
                <!-- Baris 2: jumlah dan satuan -->
                <div class="col-md-6">
                    <p class="mb-1"><strong>Jumlah:</strong></p>
                    <p class="text-muted">{{ $bahan->jumlah }} {{ $bahan->satuan }}</p>
                </div>
                <div class="col-md-6">
                    <p class="mb-1"><strong>Status:</strong></p>
                    <!-- Menampilkan status bahan dengan warna badge berbeda -->
                    @switch($bahan->status)
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
                </div>
            </div>

            <div class="row mb-3">
                <!-- Baris 3: tanggal masuk dan kadaluarsa -->
                <div class="col-md-6">
                    <p class="mb-1"><strong>Tanggal Masuk:</strong></p>
                    <p class="text-muted">{{ $bahan->tanggal_masuk->format('d-m-Y') }}</p>
                </div>
                <div class="col-md-6">
                    <p class="mb-1"><strong>Tanggal Kadaluarsa:</strong></p>
                    <p class="text-muted">{{ $bahan->tanggal_kadaluarsa->format('d-m-Y') }}</p>
                </div>
            </div>

            <hr class="my-4">

            @if($bahan->status === 'kadaluarsa')
                <!-- Jika bahan sudah kadaluarsa, tampilkan tombol hapus -->
                <div class="text-center">
                    <form action="{{ route('gudang.bahan.destroy', $bahan->id) }}" method="POST"
                        onsubmit="return confirm('Yakin ingin menghapus bahan ini secara permanen?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger px-4 py-2 shadow-sm">
                            <i class="bi bi-trash3 me-1"></i> Hapus Bahan
                        </button>
                    </form>
                </div>
            @else
                <!-- Jika bahan belum kadaluarsa, tampilkan peringatan bahwa tidak bisa dihapus -->
                <div class="alert alert-danger text-center shadow-sm mt-3">
                    <i class="bi bi-x-circle me-2"></i>
                    Bahan ini tidak dapat dihapus karena statusnya 
                    <strong>{{ ucfirst($bahan->status) }}</strong>.
                </div>
            @endif
        </div>
    </div>
</div>

@endsection
<!-- Akhir dari konten utama halaman -->
