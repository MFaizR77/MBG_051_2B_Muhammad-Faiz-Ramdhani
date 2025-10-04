@extends('dapur.dashboard')

@section('content')
<div class="container">
    <h3><i class="bi bi-file-earmark-text me-2"></i>Detail Permintaan</h3>
    <a href="{{ route('dapur.permintaan.status') }}" class="btn btn-secondary mb-3">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Status
    </a>

    <div class="row">
        <div class="col-md-6">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <strong>Informasi Permintaan</strong>
                </div>
                <div class="card-body">
                    <p><strong>Tanggal Masak:</strong> {{ $permintaan->tgl_masak->format('d-m-Y') }}</p>
                    <p><strong>Menu:</strong> {{ $permintaan->menu_makan }}</p>
                    <p><strong>Jumlah Porsi:</strong> {{ $permintaan->jumlah_porsi }}</p>
                    <p><strong>Status:</strong>
                        @switch($permintaan->status)
                            @case('menunggu')
                                <span class="badge bg-warning text-dark">Menunggu</span>
                                @break
                            @case('disetujui')
                                <span class="badge bg-success">Disetujui</span>
                                @break
                            @case('ditolak')
                                <span class="badge bg-danger">Ditolak</span>
                                @break
                        @endswitch
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <strong>Daftar Bahan Diminta</strong>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @forelse($permintaan->details as $detail)
                            <li class="list-group-item d-flex justify-content-between">
                                <span>{{ $detail->bahan->nama }}</span>
                                <span>{{ $detail->jumlah_diminta }} {{ $detail->bahan->satuan }}</span>
                            </li>
                        @empty
                            <li class="list-group-item text-muted">Tidak ada bahan</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection