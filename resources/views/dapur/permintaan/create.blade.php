@extends('dapur.dashboard') 

@section('content')
<div class="container">
    <h3>Buat Permintaan Bahan</h3>
    <a href="{{ route('dapur.permintaan.status') }}" class="btn btn-secondary mb-3">← Lihat Status Permintaan</a>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('dapur.permintaan.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Tanggal Masak</label>
            <input type="date" name="tgl_masak" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Menu yang akan dibuat</label>
            <input type="text" name="menu_makan" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Jumlah Porsi</label>
            <input type="number" name="jumlah_porsi" class="form-control" min="1" required>
        </div>

        <h5>Daftar Bahan yang Diminta</h5>
        <div id="bahan-list">
            <div class="row mb-2">
                <div class="col-md-6">
                    <select name="bahan_id[]" class="form-select bahan-select" required>
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
                <div class="col-md-1 d-flex align-items-center">
                    <button type="button" class="btn btn-sm btn-outline-danger remove-bahan">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </div>
        </div>

        <button type="button" id="add-bahan" class="btn btn-outline-primary mb-3">
            <i class="bi bi-plus"></i> Tambah Bahan
        </button>

        <div class="d-grid">
            <button type="submit" class="btn btn-primary"
                    onclick="return confirm('Simpan permintaan ini?')">
                Kirim Permintaan
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const bahanList = document.getElementById('bahan-list');
    const addButton = document.getElementById('add-bahan');

    addButton.addEventListener('click', function () {
        const newRow = document.createElement('div');
        newRow.className = 'row mb-2';
        newRow.innerHTML = `
            <div class="col-md-6">
                <select name="bahan_id[]" class="form-select bahan-select" required>
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
            <div class="col-md-1 d-flex align-items-center">
                <button type="button" class="btn btn-sm btn-outline-danger remove-bahan">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        `;
        bahanList.appendChild(newRow);

        // Add event listener to new remove button
        newRow.querySelector('.remove-bahan').addEventListener('click', function () {
            if (bahanList.children.length > 1) {
                bahanList.removeChild(newRow);
            }
        });
    });

    // Add event listeners to existing remove buttons
    document.querySelectorAll('.remove-bahan').forEach(button => {
        button.addEventListener('click', function () {
            const row = this.closest('.row');
            if (bahanList.children.length > 1) {
                bahanList.removeChild(row);
            }
        });
    });
});
</script>
@endsection