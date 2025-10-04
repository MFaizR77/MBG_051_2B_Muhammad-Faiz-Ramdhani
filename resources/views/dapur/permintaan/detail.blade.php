@extends('dapur.dashboard')

@section('content')
<div class="container">
    <h3>Detail Permintaan</h3>
    <a href="{{ route('dapur.permintaan.status') }}" class="btn btn-secondary mb-3">← Kembali ke Status</a>

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Informasi Umum</h5>
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

    <h5>Daftar Bahan yang Diminta</h5>
    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>No</th>
                <th>Nama Bahan</th>
                <th>Jumlah Diminta</th>
            </tr>
        </thead>
        <tbody>
            @foreach($permintaan->details as $detail)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $detail->bahan->nama }} ({{ $detail->bahan->satuan }})</td>
                    <td>{{ $detail->jumlah_diminta }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection