@extends('dapur.dashboard') <!-- Menggunakan layout utama dari folder dapur -->

@section('content')
<div class="container py-4"> <!-- Container utama halaman -->
    <div class="card shadow-lg border-0"> <!-- Card utama untuk form permintaan bahan -->
        <div class="card-header bg-primary text-white text-center ">
            <h3 class="mb-0"> Buat Permintaan Bahan Masakan</h3>
        </div>

        <div class="card-body p-4"> <!-- Isi utama card -->
            <!-- Tombol kembali ke halaman status permintaan -->
            <a href="{{ route('dapur.permintaan.status') }}" class="btn btn-sm btn-outline-secondary mb-4">
                ← Lihat Status Permintaan
            </a>

            <!-- Tampilkan error validasi form jika ada -->
            @if ($errors->any())
                <div class="alert alert-danger rounded-3">
                    <strong>Terjadi kesalahan:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form input data permintaan bahan -->
            <form action="{{ route('dapur.permintaan.store') }}" method="POST" class="needs-validation" novalidate>
                @csrf <!-- Token keamanan Laravel -->

                <!-- Input utama: tanggal, menu, dan jumlah porsi -->
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Tanggal Masak</label>
                        <input type="date" name="tgl_masak" class="form-control" required>
                    </div>

                    <div class="col-md-5">
                        <label class="form-label fw-semibold">Menu yang akan dibuat</label>
                        <input type="text" name="menu_makan" class="form-control" placeholder="Contoh: Nasi Goreng Spesial" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Jumlah Porsi</label>
                        <input type="number" name="jumlah_porsi" class="form-control" min="1" required>
                    </div>
                </div>

                <hr class="my-4"> <!-- Garis pemisah -->

                <h5 class="fw-bold text-primary mb-3">Daftar Bahan yang Diminta</h5>

                <!-- Area dinamis untuk menambah baris bahan -->
                <div id="bahan-list">
                    <div class="row mb-2 align-items-center bahan-row">
                        <!-- Pilih bahan dari daftar stok -->
                        <div class="col-md-6">
                            <select name="bahan_id[]" class="form-select" required>
                                <option value="">-- Pilih Bahan --</option>
                                @foreach($bahanTersedia as $bahan)
                                    <option value="{{ $bahan->id }}">
                                        {{ $bahan->nama }} ({{ $bahan->jumlah }} {{ $bahan->satuan }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Jumlah bahan yang diminta -->
                        <div class="col-md-5">
                            <input type="number" name="jumlah_diminta[]" class="form-control" min="1" placeholder="Jumlah" required>
                        </div>

                        <!-- Tombol hapus baris bahan -->
                        <div class="col-md-1 text-center">
                            <button type="button" class="btn btn-outline-danger btn-sm remove-bahan rounded-circle">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Tombol untuk menambah baris bahan baru -->
                <div class="mt-3">
                    <button type="button" id="add-bahan" class="btn btn-outline-primary">
                        <i class="bi bi-plus-circle me-1"></i> Tambah Bahan
                    </button>
                </div>

                <!-- Tombol submit untuk mengirim permintaan -->
                <div class="text-center mt-5">
                    <button type="submit" class="btn btn-lg btn-success px-5 shadow"
                            onclick="return confirm('Simpan permintaan ini?')">
                        <i class="bi bi-send-check me-2"></i> Kirim Permintaan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Tombol kembali ke dashboard -->
<div class="text-center mt-4">
        <a href="{{ url('/dapur ') }}" class="btn btn-outline-primary rounded-pill px-4">
            <i class="bi bi-house-door me-1"></i> Kembali ke Dashboard
        </a>
</div>

<!-- Script untuk menambah/menghapus baris bahan secara dinamis -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const bahanList = document.getElementById('bahan-list');
    const addButton = document.getElementById('add-bahan');

    // Event tambah baris bahan
    addButton.addEventListener('click', function () {
        const newRow = document.createElement('div');
        newRow.className = 'row mb-2 align-items-center bahan-row';
        newRow.innerHTML = `
            <div class="col-md-6">
                <select name="bahan_id[]" class="form-select" required>
                    <option value="">-- Pilih Bahan --</option>
                    @foreach($bahanTersedia as $bahan)
                        <option value="{{ $bahan->id }}">
                            {{ $bahan->nama }} ({{ $bahan->jumlah }} {{ $bahan->satuan }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-5">
                <input type="number" name="jumlah_diminta[]" class="form-control" min="1" placeholder="Jumlah" required>
            </div>
            <div class="col-md-1 text-center">
                <button type="button" class="btn btn-outline-danger btn-sm remove-bahan rounded-circle">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        `;
        bahanList.appendChild(newRow);

        // Tambahkan event hapus pada baris baru
        newRow.querySelector('.remove-bahan').addEventListener('click', function () {
            if (bahanList.children.length > 1) {
                bahanList.removeChild(newRow);
            }
        });
    });

    // Event hapus baris bahan yang sudah ada
    document.querySelectorAll('.remove-bahan').forEach(button => {
        button.addEventListener('click', function () {
            const row = this.closest('.bahan-row');
            if (bahanList.children.length > 1) {
                bahanList.removeChild(row);
            }
        });
    });
});
</script>
@endsection
