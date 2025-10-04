@extends('gudang.dashboard')

@section('content')
<div class="container">
    <h3>Daftar Permintaan dari Dapur</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($permintaanList->isEmpty())
        <div class="alert alert-info">Tidak ada permintaan yang menunggu persetujuan.</div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Tanggal Masak</th>
                        <th>Menu</th>
                        <th>Porsi</th>
                        <th>Pemohon</th>
                        <th>Bahan yang Diminta</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($permintaanList as $permintaan)
                        <tr>
                            <td>{{ $permintaan->tgl_masak->format('d-m-Y')}}</td>
                            <td>{{ $permintaan->menu_makan }}</td>
                            <td>{{ $permintaan->jumlah_porsi }}</td>
                            <td>{{ $permintaan->pemohon->name }}</td>
                            <td>
                                <ul class="mb-0" style="padding-left: 1.2rem;">
                                    @foreach($permintaan->details as $detail)
                                        <li>
                                            {{ $detail->bahan->nama }}:
                                            <strong>{{ $detail->jumlah_diminta }} {{ $detail->bahan->satuan }}</strong>
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>
                                <form action="{{ route('gudang.permintaan.approve', $permintaan->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success"
                                            onclick="return confirm('Setujui permintaan ini? Stok akan berkurang otomatis.')">
                                        <i class="bi bi-check-circle"></i> Setujui
                                    </button>
                                </form>
                                <button type="button" class="btn btn-sm btn-danger mt-1"
                                        data-bs-toggle="modal" data-bs-target="#rejectModal{{ $permintaan->id }}">
                                    <i class="bi bi-x-circle"></i> Tolak
                                </button>

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
                                                        <textarea name="alasan" class="form-control" rows="3"
                                                                  placeholder="Misal: Stok tidak mencukupi"></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-danger">Tolak Permintaan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection