@extends('gudang.dashboard')

@section('content')
    <div class="container">
        <h3>Tambah Bahan Baku Baru</h3>
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
                <form action="{{ route('gudang.bahan.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nama Bahan</label>
                        <input type="text" name="nama" class="form-control" id="nama" value="{{ old('nama') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select name="kategori" id="kategori" class="form-select" required>
                            <option value="">-- Pilih Kategori --</option>
                            <option value="Karbohidrat" {{ old(key: 'kategori') == 'Karbohidrat' ? 'selected' : '' }}>Karbohidrat
                            </option>
                            <option value="Protein Hewani" {{ old('kategori') == 'Protein Hewani' ? 'selected' : '' }}>Protein
                                Hewani</option>
                            <option value="Protein Nabati" {{ old('kategori') == 'Protein Nabati' ? 'selected' : '' }}>Protein
                                Nabati</option>
                            <option value="Sayuran" {{ old('kategori') == 'Sayuran' ? 'selected' : '' }}>Sayuran</option>
                            <option value="Bahan Masak" {{ old('kategori') == 'Bahan Masak' ? 'selected' : '' }}>Bahan Masak
                            </option>
                            <option value="Bumbu" {{ old('kategori') == 'Bumbu' ? 'selected' : '' }}>Bumbu</option>
                            <option value="Minyak & Lemak" {{ old('kategori') == 'Minyak & Lemak' ? 'selected' : '' }}>Minyak
                                & Lemak</option>
                            <option value="Buah" {{ old('kategori') == 'Buah' ? 'selected' : '' }}>Buah</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Jumlah</label>
                                <input type="number" name="jumlah" id="jumlah" class="form-control" value="{{ old('jumlah', 0) }}"
                                    min="0" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Satuan</label>
                                <input type="text" name="satuan" id="satuan" class="form-control" value="{{ old('satuan') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Tanggal Masuk</label>
                                <input type="date" name="tanggal_masuk" id="tanggal_masuk" class="form-control"
                                    value="{{ old('tanggal_masuk') }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Tanggal Kadaluarsa</label>
                                <input type="date" name="tanggal_kadaluarsa" id="tanggal_kadaluarsa" class="form-control"
                                    value="{{ old('tanggal_kadaluarsa') }}" required>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" onclick="return confirm('Simpan data bahan baku ini?')">
                        Simpan Bahan Baku
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection