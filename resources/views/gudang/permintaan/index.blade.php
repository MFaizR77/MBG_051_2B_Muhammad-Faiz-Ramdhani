@extends('gudang.dashboard')

@section('content')
<div class="container">
    <h3><i class="bi bi-clipboard me-2"></i>Permintaan dari Dapur</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($permintaanList->isEmpty())
        <div class="alert alert-info">
            <i class="bi bi-check-circle me-1"></i> Tidak ada permintaan yang menunggu persetujuan.
        </div>
    @else
        <div class="row">
            @foreach($permintaanList as $permintaan)
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-header bg-light">
                            <strong>{{ $permintaan->menu_makan }}</strong> • {{ $permintaan->jumlah_porsi }} porsi
                        </div>
                        <div class="card-body">
                            <p class="mb-1"><i class="bi bi-calendar me-1"></i> Tgl Masak: {{ $permintaan->tgl_masak->format('d-m-Y') }}</p>
                            <p class="mb-2"><i class="bi bi-person me-1"></i> Pemohon: {{ $permintaan->pemohon->name }}</p>

                            <h6>Bahan yang Diminta:</h6>
                            <ul class="mb-3">
                                @foreach($permintaan->details as $detail)
                                    <li>
                                        {{ $detail->bahan->nama }}:
                                        <strong>{{ $detail->jumlah_diminta }} {{ $detail->bahan->satuan }}</strong>
                                    </li>
                                @endforeach
                            </ul>

                            <div class="d-grid gap-2">
                                <form action="{{ route('gudang.permintaan.approve', $permintaan->id) }}" method="POST" class="d-grid">
                                    @csrf
                                    <button type="submit" class="btn btn-success"
                                            onclick="return confirm('Setujui permintaan ini? Stok akan berkurang otomatis.')">
                                        <i class="bi bi-check-circle-fill me-1"></i> Setujui
                                    </button>
                                </form>

                                <button type="button" class="btn btn-outline-danger"
                                        data-bs-toggle="modal" data-bs-target="#rejectModal{{ $permintaan->id }}">
                                    <i class="bi bi-x-circle me-1"></i> Tolak
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Tolak -->
                <div class="modal fade" id="rejectModal{{ $permintaan->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Tolak Permintaan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form action="{{ route('gudang.permintaan.reject', $permintaan->id) }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">Alasan Penolakan (Opsional)</label>
                                        <textarea name="alasan" class="form-control" rows="2"
                                                  placeholder="Contoh: Stok tidak mencukupi"></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('Yakin ingin menolak permintaan ini?')">
                                        Tolak Permintaan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection