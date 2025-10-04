@extends('dapur.dashboard') 
{{-- Menggunakan layout utama dashboard dapur --}}

@section('content')
<div class="container py-4">
    <!-- Kartu utama yang menampilkan detail permintaan -->
    <div class="card shadow-lg border-0 rounded-4 mb-4">
        <!-- Header judul halaman -->
        <div class="card-header bg-primary text-white d-flex align-items-center">
            <i class="bi bi-file-earmark-text fs-4 me-2"></i>
            <h4 class="mb-0">Detail Permintaan Bahan</h4>
        </div>

        <div class="card-body p-4">
            <!-- Tombol kembali ke halaman status permintaan -->
            <a href="{{ route('dapur.permintaan.status') }}" class="btn btn-outline-secondary mb-4 px-3">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Status
            </a>

            <div class="row g-4">
                <!-- ===========================
                     BAGIAN KIRI: Informasi Permintaan
                ============================ -->
                <div class="col-md-6">
                    <div class="card shadow-sm border-0 rounded-4 h-100">
                        <div class="card-header bg-light fw-semibold rounded-top-4">
                            <i class="bi bi-info-circle me-2 text-primary"></i>Informasi Permintaan
                        </div>
                        <div class="card-body">
                            <!-- Menampilkan detail data permintaan -->
                            <p class="mb-2"><strong>Tanggal Masak:</strong> 
                                <span class="text-muted">{{ $permintaan->tgl_masak->format('d-m-Y') }}</span>
                            </p>
                            <p class="mb-2"><strong>Menu:</strong> 
                                <span class="text-muted">{{ $permintaan->menu_makan }}</span>
                            </p>
                            <p class="mb-2"><strong>Jumlah Porsi:</strong> 
                                <span class="text-muted">{{ $permintaan->jumlah_porsi }}</span>
                            </p>
                            <!-- Status permintaan ditampilkan dengan warna berbeda -->
                            <p class="mb-0"><strong>Status:</strong>
                                @switch($permintaan->status)
                                    @case('menunggu')
                                        <span class="badge bg-warning text-dark fs-6 px-3 py-2 rounded-pill">
                                            <i class="bi bi-hourglass-split me-1"></i> Menunggu
                                        </span>
                                        @break
                                    @case('disetujui')
                                        <span class="badge bg-success fs-6 px-3 py-2">
                                            <i class="bi bi-check-circle me-1"></i> Disetujui
                                        </span>
                                        @break
                                    @case('ditolak')
                                        <span class="badge bg-danger fs-6 px-3 py-2 rounded-pill">
                                            <i class="bi bi-x-circle me-1"></i> Ditolak
                                        </span>
                                        @break
                                @endswitch
                            </p>
                        </div>
                    </div>
                </div>

                <!-- ===========================
                     BAGIAN KANAN: Daftar Bahan Diminta
                ============================ -->
                <div class="col-md-6">
                    <div class="card shadow-sm border-0 rounded-4 h-100">
                        <div class="card-header bg-light fw-semibold rounded-top-4">
                            <i class="bi bi-basket me-2 text-primary"></i>Daftar Bahan Diminta
                        </div>
                        <div class="card-body p-0">
                            <ul class="list-group list-group-flush">
                                <!-- Menampilkan daftar bahan yang diminta -->
                                @forelse($permintaan->details as $detail)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-dot text-primary fs-4 me-1"></i>
                                            <span>{{ $detail->bahan->nama }}</span>
                                        </div>
                                        <span class="fw-semibold">{{ $detail->jumlah_diminta }} {{ $detail->bahan->satuan }}</span>
                                    </li>
                                @empty
                                    <!-- Jika tidak ada bahan -->
                                    <li class="list-group-item text-center text-muted py-3">
                                        <i class="bi bi-exclamation-circle me-1"></i> Tidak ada bahan yang diminta
                                    </li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tombol kembali ke dashboard -->
    <div class="text-center mt-4">
        <a href="{{ url('/dapur ') }}" class="btn btn-outline-primary rounded-pill px-4">
            <i class="bi bi-house-door me-1"></i> Kembali ke Dashboard
        </a>
    </div>
</div>
@endsection
