<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MBG - Dapur</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light d-flex flex-column min-vh-100">

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-success shadow-sm">
    <div class="container">
      <a class="navbar-brand fw-semibold letter-spacing-1" href="{{ url('/dapur') }}">MBG - Dapur</a>
      <div class="d-flex align-items-center">
        <a href="{{ url('/dapur/permintaan') }}" class="btn btn-outline-light btn-sm me-2">
          <i class="bi bi-journal-plus me-1"></i> Ajukan Permintaan
        </a>
        <a href="{{ url('/dapur/status') }}" class="btn btn-outline-light btn-sm me-2">
          <i class="bi bi-clipboard-check me-1"></i> Status Permintaan
        </a>
        <form action="{{ route('logout') }}" method="POST" class="d-inline">
          @csrf
          <button type="submit" class="btn btn-link text-white btn-sm px-3"
                  onclick="return confirm('Yakin ingin logout?')">
            <i class="bi bi-box-arrow-right me-1"></i> Logout
          </button>
        </form>
      </div>
    </div>
  </nav>

  <!-- Main Content -->
  <main class="container my-5 flex-fill">
    @if (!View::hasSection('content'))
      <div class="text-center mb-5">
        <h2 class="fw-bold text-success">Selamat Datang di Dapur MBG</h2>
      </div>

      <div class="row g-4 justify-content-center">
        <!-- Card 1 -->
        <div class="col-md-5">
          <div class="card text-center shadow-sm border-0 h-100">
            <div class="card-body d-flex flex-column justify-content-center">
              <div class="bg-success bg-opacity-25 text-success rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 64px; height: 64px;">
                <i class="bi bi-journal-plus fs-3"></i>
              </div>
              <h5 class="fw-semibold mb-2">Ajukan Permintaan Bahan</h5>
              <p class="text-muted mb-3">Buat permintaan bahan baku untuk kebutuhan memasak dapur.</p>
              <a href="{{ url('/dapur/permintaan') }}" class="btn btn-success fw-medium mt-auto">
                <i class="bi bi-plus-circle me-1"></i> Buat Permintaan
              </a>
            </div>
          </div>
        </div>

        <!-- Card 2 -->
        <div class="col-md-5">
          <div class="card text-center shadow-sm border-0 h-100">
            <div class="card-body d-flex flex-column justify-content-center">
              <div class="bg-warning bg-opacity-25 text-warning rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 64px; height: 64px;">
                <i class="bi bi-clipboard-check fs-3"></i>
              </div>
              <h5 class="fw-semibold mb-2">Status Permintaan</h5>
              <p class="text-muted mb-3">Lihat status permintaan bahan: menunggu, disetujui, atau ditolak.</p>
              <a href="{{ url('/dapur/status') }}" class="btn btn-warning text-dark fw-medium mt-auto">
                <i class="bi bi-eye me-1"></i> Lihat Status
              </a>
            </div>
          </div>
        </div>
      </div>
    @else
      @yield('content')
    @endif
  </main>

  <!-- Footer -->
  <footer class="bg-success text-white text-center py-3 mt-auto">
    © 2025 MBG System — Dapur Division. All rights reserved.
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('js/ets.js') }}"></script>
</body>
</html>
