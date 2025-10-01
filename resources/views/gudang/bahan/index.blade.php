@extends('gudang.dashboard')

@section('content')
<div class="container">
    <h3>Daftar Bahan Baku</h3>
    <a href="{{ route('gudang.bahan.create') }}" class="btn btn-primary mb-3">+ Tambah Bahan</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Nama</th>
                <th>Kategori</th>
                <th>Jumlah</th>
                <th>Satuan</th>
                <th>Tgl Masuk</th>
                <th>Tgl Kadaluarsa</th>
                <th>Status</th>
                <th>Aksi</th> {{-- Tambah kolom aksi --}}
            </tr>
        </thead>
        <tbody>
            @forelse($bahan as $item)
                <tr>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->kategori }}</td>
                    <td>{{ $item->jumlah }}</td>
                    <td>{{ $item->satuan }}</td>
                    <td>{{ $item->tanggal_masuk->format('d-m-Y') }}</td>
                    <td>{{ $item->tanggal_kadaluarsa->format('d-m-Y') }}</td>
                    <td>
                        @switch($item->status)
                            @case('habis')
                                <span class="badge bg-secondary">Habis</span>
                                @break
                            @case('kadaluarsa')
                                <span class="badge bg-danger">Kadaluarsa</span>
                                @break
                            @case('segera_kadaluarsa')
                                <span class="badge bg-warning text-dark">Segera Kadaluarsa</span>
                                @break
                            @default
                                <span class="badge bg-success">Tersedia</span>
                        @endswitch
                    </td>
                    <td>
                        <a href="{{ route('gudang.bahan.edit', $item->id) }}" 
                           class="btn btn-sm btn-warning">
                            Edit Stok
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">Belum ada data bahan baku</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
