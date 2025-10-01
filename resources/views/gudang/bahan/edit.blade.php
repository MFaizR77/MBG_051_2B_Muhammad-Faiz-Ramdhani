@extends('gudang.dashboard')

@section('content')
<div class="container">
    <h3>Edit Stok Bahan: {{ $bahan->nama }}</h3>
    <a href="{{ route('gudang.bahan.index') }}" class="btn btn-secondary mb-3">← Kembali</a>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('gudang.bahan.update', $bahan->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Jumlah Stok</label>
                    <input type="number" name="jumlah" class="form-control"
                           value="{{ old('jumlah', $bahan->jumlah) }}" min="0" required>
                </div>
                <button type="submit" class="btn btn-primary"
                        onclick="return confirm('Update stok bahan ini?')">
                    Simpan Perubahan
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
