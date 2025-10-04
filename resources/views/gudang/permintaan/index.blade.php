@extends('gudang.dashboard') 
<!-- Menggunakan layout utama dari dashboard gudang -->

@section('content')
<!-- Awal dari bagian konten utama halaman -->

<div class="container my-4">
    <!-- Container utama untuk membungkus seluruh isi halaman -->

    <div class="d-flex align-items-center mb-4">
        <!-- Bagian header halaman dengan ikon dan judul -->
        <i class="bi bi-clipboard-check fs-3 text-primary me-2"></i>
        <h3 class="m-0 fw-semibold">Permintaan dari Dapur</h3>
    </div>

    {{-- Alert Sukses --}}
    @if(session('success'))
        <!-- Menampilkan notifikasi sukses jika ada pesan berhasil -->
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Tidak ada permintaan --}}
    @if($permintaanList->isEmpty())
        <!-- Jika tidak ada permintaan, tampilkan pesan informasi -->
        <div class="alert alert-info shadow-sm d-flex align-items-center">
            <i class="bi bi-inbox me-2 fs-5"></i>
            <div>Tidak ada permintaan yang menunggu persetujuan.</div>
        </div>
    @else
        <!-- Jika ada data permintaan, tampilkan dalam bentuk grid card -->
        <div class="row">
            @foreach($permintaanList as $permintaan)
                <!-- Setiap permintaan ditampilkan sebagai 1 card -->
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card shadow-sm border-0 h-100">
                        <!-- Card utama untuk menampilkan detail permintaan -->
                        <div class="card-header bg-primary text-white fw-semibold">
                            <!-- Header card berisi nama menu dan jumlah porsi -->
                            {{ $permintaan->menu_makan }} 
                            <span class="text-light opacity-75">• {{ $permintaan->jumlah_porsi }} porsi</span>
                        </div>

                        <div class="card-body">
                            <!-- Isi dari card permintaan -->
                            <p class="mb-1">
                                <i class="bi bi-calendar-date me-2 text-muted"></i> 
                                <strong>{{ $permintaan->tgl_masak->format('d M Y') }}</strong>
                            </p>
                            <p class="mb-2">
                                <i class="bi bi-person-circle me-2 text-muted"></i> 
                                Pemohon: {{ $permintaan->pemohon->name }}
                            </p>

                            <h6 class="fw-semibold mt-3 mb-2 border-bottom pb-1">Bahan yang Diminta:</h6>
                            <!-- Daftar bahan yang diminta -->
                            <ul class="mb-3 small">
                                @foreach($permintaan->details as $detail)
                                    @if($detail->bahan->status === 'kadaluarsa')
                                        <li class="text-danger">
                                            {{ $detail->bahan->nama }}: 
                                            <strong>{{ $detail->jumlah_diminta }} {{ $detail->bahan->satuan }}</strong> (Kadaluarsa)
                                        </li>
                                    @elseif($detail->bahan->status === 'segera_kadaluarsa')
                                        <li class="text-warning">
                                            {{ $detail->bahan->nama }}: 
                                            <strong>{{ $detail->jumlah_diminta }} {{ $detail->bahan->satuan }}</strong> (Segera Kadaluarsa)
                                        </li>
                                    @elseif($detail->bahan->jumlah < $detail->jumlah_diminta)
                                        <li class="text-danger">
                                            {{ $detail->bahan->nama }}: 
                                            <strong>{{ $detail->jumlah_diminta }} {{ $detail->bahan->satuan }}</strong> (Stok Tidak Cukup)
                                        </li>
                                    @else
                                    <li>
                                        {{ $detail->bahan->nama }}: 
                                        <strong>{{ $detail->jumlah_diminta }} {{ $detail->bahan->satuan }}</strong>
                                    </li>
                                    @endif
                                @endforeach
                            </ul>

                            <div class="d-grid gap-2">
                                <!-- Tombol aksi: Setujui atau Tolak -->
                                <form action="{{ route('gudang.permintaan.approve', $permintaan->id) }}" method="POST">
                                    @csrf
                                    <!-- Tombol untuk menyetujui permintaan,
                                      validasi apakah ada bahan yang Kadaluarsa atau tidak, 
                                      dan validasi apakah melebihi stok atau tidak-->
                                    @if($permintaan->details->contains(fn($d) => $d->bahan->status === 'kadaluarsa'))
                                        <button type="button" class="btn btn-success" disabled>
                                            <i class="bi bi-check-circle-fill me-1"></i> Setujui
                                        </button>
                                        <p class="text-danger mt-1">Tidak dapat di setujui karena ada bahan yang Kadaluarsa</p>
                                    @elseif($permintaan->details->contains(fn($d) => $d->bahan->jumlah < $d->jumlah_diminta))
                                        <button type="button" class="btn btn-success" disabled>
                                            <i class="bi bi-check-circle-fill me-1"></i> Setujui
                                        </button>
                                        <p class="text-danger mt-1">Tidak dapat di setujui karena ada bahan yang Tidak Cukup Stok</p>    
                                    @else    
                                        <button type="submit" class="btn btn-success"
                                                onclick="return confirm('Setujui permintaan ini? Stok akan berkurang otomatis.')">
                                            <i class="bi bi-check-circle-fill me-1"></i> Setujui
                                        </button>
                                    @endif    
                                </form>

                                <!-- Tombol untuk menolak permintaan (membuka modal) -->
                                <button type="button" class="btn btn-outline-danger"
                                        data-bs-toggle="modal" data-bs-target="#rejectModal{{ $permintaan->id }}">
                                    <i class="bi bi-x-circle me-1"></i> Tolak
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal konfirmasi penolakan permintaan -->
                <div class="modal fade" id="rejectModal{{ $permintaan->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content shadow-lg">
                            <div class="modal-header bg-danger text-white">
                                <!-- Header modal dengan ikon dan judul -->
                                <h5 class="modal-title">
                                    <i class="bi bi-x-circle me-2"></i>Tolak Permintaan
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>

                            <!-- Form untuk mengirim alasan penolakan -->
                            <form action="{{ route('gudang.permintaan.reject', $permintaan->id) }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Alasan Penolakan (Opsional)</label>
                                        <textarea name="alasan" class="form-control" rows="2"
                                                  placeholder="Contoh: Stok tidak mencukupi"></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <!-- Tombol di bagian bawah modal -->
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        <i class="bi bi-arrow-left me-1"></i> Batal
                                    </button>
                                    <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('Yakin ingin menolak permintaan ini?')">
                                        <i class="bi bi-x-circle-fill me-1"></i> Tolak Permintaan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Akhir modal -->
            @endforeach
        </div>
    @endif
</div>

@endsection
<!-- Akhir dari bagian konten utama halaman -->
