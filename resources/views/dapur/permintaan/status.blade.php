@extends('dapur.dashboard')

@section('content')
<div class="container">
    <h3>Status Permintaan Bahan</h3>
    <a href="{{ route('dapur.permintaan.create') }}" class="btn btn-primary mb-3">
        <i class="bi bi-plus"></i> Buat Permintaan Baru
    </a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
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
                    <td>
                        <a href="{{ route('dapur.permintaan.detail', $item->id) }}" class="btn btn-sm btn-info">
                            <i class="bi bi-eye"></i> Detail
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Belum ada permintaan</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection