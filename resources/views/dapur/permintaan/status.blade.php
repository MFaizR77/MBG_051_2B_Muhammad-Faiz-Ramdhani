@extends('dapur.dashboard')

@section('content')
<div class="container">
    <h3><i class="bi bi-clipboard-check me-2"></i>Status Permintaan Bahan</h3>

    <a href="{{ route('dapur.permintaan.create') }}" class="btn btn-success mb-3">
        <i class="bi bi-plus-circle me-1"></i> Buat Permintaan Baru
    </a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Tanggal Masak</th>
                        <th>Menu</th>
                        <th>Porsi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($permintaan as $item)
                        <tr>
                            <td>{{ $item->tgl_masak->format('d-m-Y') }}</td>
                            <td>{{ $item->menu_makan }}</td>
                            <td>{{ $item->jumlah_porsi }}</td>
                            <td>
                                @switch($item->status)
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
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                <i class="bi bi-inbox me-2"></i>Belum ada permintaan
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection