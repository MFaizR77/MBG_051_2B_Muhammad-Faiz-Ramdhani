@extends('gudang.dashboard')

@section('content')
    <div class="container my-4">

        <!-- Header Halaman: Judul & Tombol Kembali -->
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="d-flex align-items-center">
                <i class="bi bi-plus-circle text-primary fs-3 me-2"></i>
                <h3 class="fw-semibold mb-0">Tambah Bahan Baku Baru</h3>
            </div>
            <a href="{{ route('gudang.bahan.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

        <!-- Notifikasi Error Validasi Input -->
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i> Terjadi kesalahan:
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Kartu Form Input Data Bahan -->
        <div class="card shadow-sm border-0">
            <div class="card-body">

                <!-- Form Tambah Bahan Baku -->
                <form action="{{ route('gudang.bahan.store') }}" method="POST" class="needs-validation" novalidate>
                    @csrf <!-- Token keamanan Laravel -->

                    <!-- Input Nama Bahan -->
                    <div class="mb-3">
                        <label for="nama" class="form-label fw-semibold">Nama Bahan</label>
                        <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama') }}" required>
                    </div>

                    <!-- Input Kategori Bahan -->
                    <div class="mb-3">
                        <label for="kategori" class="form-label fw-semibold">Kategori</label>
                        <select name="kategori" id="kategori" class="form-select" required>
                            <option value="">-- Pilih Kategori --</option>
                            <option value="Karbohidrat" {{ old('kategori') == 'Karbohidrat' ? 'selected' : '' }}>Karbohidrat
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

                    <!-- Input Jumlah & Satuan -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="jumlah" class="form-label fw-semibold">Jumlah</label>
                                <input type="number" name="jumlah" id="jumlah" class="form-control" min="0"
                                    value="{{ old('jumlah', 0) }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="satuan" class="form-label fw-semibold">Satuan</label>
                                <select name="satuan" id="satuan" class="form-select" required>
                                    <option value="">-- Pilih Satuan --</option>
                                    <option value="kg" {{ old('satuan') == 'kg' ? 'selected' : '' }}>kg</option>
                                    <option value="gram" {{ old('satuan') == 'gram' ? 'selected' : '' }}>gram</option>
                                    <option value="liter" {{ old('satuan') == 'liter' ? 'selected' : '' }}>liter</option>
                                    <option value="ml" {{ old('satuan') == 'ml' ? 'selected' : '' }}>ml</option>
                                    <option value="butir" {{ old('satuan') == 'butir' ? 'selected' : '' }}>butir</option>
                                    <option value="buah" {{ old('satuan') == 'buah' ? 'selected' : '' }}>buah</option>
                                    <option value="potong" {{ old('satuan') == 'potong' ? 'selected' : '' }}>potong</option>
                                    <option value="ikat" {{ old('satuan') == 'ikat' ? 'selected' : '' }}>ikat</option>
                                    <option value="bungkus" {{ old('satuan') == 'bungkus' ? 'selected' : '' }}>bungkus
                                    </option>
                                    <option value="sachet" {{ old('satuan') == 'sachet' ? 'selected' : '' }}>sachet</option>
                                    <option value="kaleng" {{ old('satuan') == 'kaleng' ? 'selected' : '' }}>kaleng</option>
                                    <option value="botol" {{ old('satuan') == 'botol' ? 'selected' : '' }}>botol</option>
                                    <option value="pack" {{ old('satuan') == 'pack' ? 'selected' : '' }}>pack</option>
                                    <option value="pcs" {{ old('satuan') == 'pcs' ? 'selected' : '' }}>pcs</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Input Tanggal Masuk & Kadaluarsa -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tanggal_masuk" class="form-label fw-semibold">Tanggal Masuk</label>
                                <input type="date" name="tanggal_masuk" id="tanggal_masuk" class="form-control"
                                    value="{{ old('tanggal_masuk') }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tanggal_kadaluarsa" class="form-label fw-semibold">Tanggal Kadaluarsa</label>
                                <input type="date" name="tanggal_kadaluarsa" id="tanggal_kadaluarsa" class="form-control"
                                    value="{{ old('tanggal_kadaluarsa') }}" required>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Simpan Data -->
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary px-4"
                            onclick="return confirm('Simpan data bahan baku ini?')">
                            <i class="bi bi-save2 me-1"></i> Simpan Bahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection