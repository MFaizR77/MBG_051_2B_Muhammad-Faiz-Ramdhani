@extends('dapur.dashboard') 
{{-- Menggunakan layout utama untuk halaman dapur --}}

@section('content')
<div class="container py-4">
    <!-- Kartu utama yang menampilkan daftar status permintaan bahan -->
    <div class="card shadow-lg border-0 rounded-4">
        <!-- Header card dengan judul dan tombol "Buat Permintaan" -->
        <div class="card-header bg-primary text-white d-flex align-items-center justify-content-between">
            <div>
                <i class="bi bi-clipboard-check fs-4 me-2"></i>
                <h4 class="d-inline mb-0">Status Permintaan Bahan</h4>
            </div>
            <!-- Tombol untuk membuat permintaan baru -->
            <a href="{{ route('dapur.permintaan.create') }}" class="btn btn-light text-primary fw-semibold px-3">
                <i class="bi bi-plus-circle me-1"></i> Buat Permintaan
            </a>
        </div>

        <!-- Bagian isi utama card -->
        <div class="card-body p-4">
            <!-- Pesan notifikasi sukses (misal setelah membuat permintaan) -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Tabel responsif untuk daftar permintaan bahan -->
            <div class="table-responsive">
                <table class="table align-middle table-hover">
                    <!-- Header tabel -->
                    <thead class="table-light border-bottom border-2">
                        <tr>
                            <th class="text-primary">Tanggal Masak</th>
                            <th class="text-primary">Menu</th>
                            <th class="text-primary">Porsi</th>
                            <th class="text-primary">Status</th>
                            <th class="text-primary text-center">Aksi</th>
                        </tr>
                    </thead>

                    <!-- Isi tabel -->
                    <tbody>
                        @forelse($permintaan as $item)
                            <!-- Baris data permintaan -->
                            <tr>
                                <td class="fw-semibold">{{ $item->tgl_masak->format('d-m-Y') }}</td>
                                <td>{{ $item->menu_makan }}</td>
                                <td>{{ $item->jumlah_porsi }}</td>

                                <!-- Badge status dengan warna berbeda -->
                                <td>
                                    @switch($item->status)
                                        @case('menunggu')
                                            <span class="badge bg-warning text-dark px-3 py-2">
                                                <i class="bi bi-hourglass-split me-1"></i> Menunggu
                                            </span>
                                            @break
                                        @case('disetujui')
                                            <span class="badge bg-success px-3 py-2">
                                                <i class="bi bi-check-circle me-1"></i> Disetujui
                                            </span>
                                            @break
                                        @case('ditolak')
                                            <span class="badge bg-danger px-3 py-2">
                                                <i class="bi bi-x-circle me-1"></i> Ditolak
                                            </span>
                                            @break
                                    @endswitch
                                </td>

                                <!-- Tombol aksi untuk melihat detail permintaan -->
                                <td class="text-center">
                                    <a href="{{ route('dapur.permintaan.detail', $item->id) }}" 
                                       class="btn btn-sm btn-outline-primary px-3 py-1 detail-btn">
                                        <i class="bi bi-eye me-1"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <!-- Jika belum ada data permintaan -->
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    <i class="bi bi-inbox fs-4 d-block mb-2"></i>
                                    Belum ada permintaan
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Tombol kembali ke dashboard utama dapur -->
<div class="text-center mt-4">
    <a href="{{ url('/dapur ') }}" class="btn btn-outline-primary rounded-pill px-4">
        <i class="bi bi-house-door me-1"></i> Kembali ke Dashboard
    </a>
</div>
@endsection
