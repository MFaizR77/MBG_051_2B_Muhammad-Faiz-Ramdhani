@extends('gudang.dashboard')

@section('content')
<div class="container">
    <h3>Konfirmasi Hapus Bahan Baku</h3>
    <a href="{{ route('gudang.bahan.index') }}" class="btn btn-secondary mb-3">← Kembali</a>

    <div class="alert alert-warning">
        <strong>Perhatian!</strong> Anda akan menghapus data berikut:
    </div>

    <div class="card">
        <div class="card-body">
            <p><strong>Nama:</strong> {{ $bahan->nama }}</p>
            <p><strong>Kategori:</strong> {{ $bahan->kategori }}</p>
            <p><strong>Jumlah:</strong> {{ $bahan->jumlah }} {{ $bahan->satuan }}</p>
            <p><strong>Tanggal Masuk:</strong> {{ $bahan->tanggal_masuk->format('d-m-Y') }}</p>
            <p><strong>Tanggal Kadaluarsa:</strong> {{ $bahan->tanggal_kadaluarsa->format('d-m-Y') }}</p>
            <p><strong>Status:</strong>
                @switch($bahan->status)
                    @case('habis') <span class="badge bg-secondary">Habis</span> @break
                    @case('kadaluarsa') <span class="badge bg-danger">Kadaluarsa</span> @break
                    @case('segera_kadaluarsa') <span class="badge bg-warning text-dark">Segera Kadaluarsa</span> @break
                    @default <span class="badge bg-success">Tersedia</span>
                @endswitch
            </p>

            @if($bahan->status === 'kadaluarsa')
                <form action="{{ route('gudang.bahan.destroy', $bahan->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus bahan ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            @else
                <div class="alert alert-danger mt-3">
                    Bahan ini tidak dapat dihapus karena statusnya <strong>{{ ucfirst($bahan->status) }}</strong>.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
