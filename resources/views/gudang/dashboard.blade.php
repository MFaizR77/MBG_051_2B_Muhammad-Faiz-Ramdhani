<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Pengaturan dasar HTML -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MBG - Gudang</title>

    <!-- Import CSS Bootstrap untuk styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Import Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>

<!-- Body dengan layout fleksibel agar footer tetap di bawah -->
<body class="d-flex flex-column min-vh-100 bg-light">

    <!-- Navbar utama halaman gudang -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm py-3">
        <div class="container">
            <!-- Nama aplikasi dan link ke halaman utama gudang -->
            <a href="{{ url('/gudang') }}" class="navbar-brand fw-bold">MBG - Gudang</a>

            <!-- Tombol navigasi kanan (kelola bahan, permintaan, logout) -->
            <div class="d-flex">
                <a href="{{ url('/gudang/bahan') }}" class="btn btn-outline-light btn-sm me-2">
                    <i class="bi bi-box me-1"></i> Kelola Bahan
                </a>
                <a href="{{ url('/gudang/permintaan') }}" class="btn btn-outline-light btn-sm me-2">
                    <i class="bi bi-clipboard me-1"></i> Permintaan Dapur
                </a>

                <!-- Tombol logout dengan konfirmasi -->
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-light btn-sm"
                            onclick="return confirm('Yakin logout?')">
                        <i class="bi bi-box-arrow-right me-1"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Konten utama halaman -->
    <main class="container my-5 flex-grow-1">
        <!-- Jika tidak ada section 'content', tampilkan halaman utama -->
        @if (!View::hasSection('content'))
            <h2 class="text-center fw-bold mb-4 text-dark">Selamat Datang di Gudang MBG</h2>

            <div class="row g-4 justify-content-center">
                <!-- Card 1: Kelola Bahan Baku -->
                <div class="col-md-5">
                    <div class="card h-100 shadow-sm border-0 text-center">
                        <div class="card-body d-flex flex-column justify-content-center">
                            <!-- Ikon dalam lingkaran -->
                            <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center mx-auto mb-3" style="width:70px; height:70px;">
                                <i class="bi bi-box fs-2"></i>
                            </div>
                            <h5 class="card-title fw-semibold">Kelola Bahan Baku</h5>
                            <p class="text-muted mb-3">Lihat, tambah, ubah, atau hapus stok bahan baku dengan mudah.</p>
                            <!-- Tombol menuju halaman bahan -->
                            <a href="{{ url('/gudang/bahan') }}" class="btn btn-primary">
                                <i class="bi bi-journal-plus me-1"></i> Kelola Sekarang
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Permintaan dari Dapur -->
                <div class="col-md-5">
                    <div class="card h-100 shadow-sm border-0 text-center">
                        <div class="card-body d-flex flex-column justify-content-center">
                            <!-- Ikon dalam lingkaran -->
                            <div class="rounded-circle bg-success bg-opacity-10 text-success d-flex align-items-center justify-content-center mx-auto mb-3" style="width:70px; height:70px;">
                                <i class="bi bi-clipboard fs-2"></i>
                            </div>
                            <h5 class="card-title fw-semibold">Permintaan dari Dapur</h5>
                            <p class="text-muted mb-3">Kelola dan proses permintaan bahan dari dapur secara efisien.</p>
                            <!-- Tombol menuju halaman permintaan -->
                            <a href="{{ url('/gudang/permintaan') }}" class="btn btn-success">
                                <i class="bi bi-eye me-1"></i> Lihat Permintaan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Jika ada section 'content', tampilkan isi halaman -->
            @yield('content')
        @endif
    </main>

    <!-- Footer selalu di bagian bawah halaman -->
    <footer class="bg-primary text-white text-center py-3 mt-auto">
        <small>&copy; {{ date('Y') }} MBG Gudang. All rights reserved.</small>
    </footer>

    <!-- Script Bootstrap dan JS tambahan -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/ets.js') }}"></script>
</body>
</html>
