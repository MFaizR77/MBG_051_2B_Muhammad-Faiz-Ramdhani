<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MBG - Dapur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar-brand {
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        .card {
            border: none;
            border-radius: 12px;
            transition: all 0.3s ease;
            height: 100%;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }
        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.1);
        }
        .card-body {
            padding: 1.5rem;
        }
        .card-title {
            font-weight: 600;
            margin-bottom: 0.75rem;
            color: #212529;
        }
        .card-text {
            font-size: 0.95rem;
            line-height: 1.5;
        }
        .btn {
            font-weight: 500;
            padding: 0.45rem 1.25rem;
            border-radius: 8px;
        }
        .welcome-header {
            font-weight: 600;
            color: #198754;
            margin-bottom: 1.5rem;
        }
        .icon-circle {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin-bottom: 1rem;
        }
        .bg-success-light {
            background-color: rgba(25, 135, 84, 0.15);
            color: #198754;
        }
        .bg-warning-light {
            background-color: rgba(255, 193, 7, 0.15);
            color: #ffc107;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-dark bg-success">
        <div class="container">
            <a href="{{ url('/dapur') }}" class="navbar-brand">MBG - Dapur</a>
            <div class="d-flex">
                <a href="{{ url('/dapur/permintaan') }}" class="btn btn-outline-light btn-sm me-2 px-3">
                    <i class="bi bi-journal-plus me-1"></i> Ajukan Permintaan
                </a>
                <a href="{{ url('/dapur/status') }}" class="btn btn-outline-light btn-sm me-2 px-3">
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

    <div class="container mt-4">
        @if (!View::hasSection('content'))
            <h2 class="welcome-header">Selamat Datang di Dapur MBG</h2>
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card shadow-sm h-100">
                        <div class="card-body text-center d-flex flex-column justify-content-center">
                            <div class="icon-circle bg-success-light mx-auto">
                                <i class="bi bi-journal-plus"></i>
                            </div>
                            <h5 class="card-title">Ajukan Permintaan Bahan</h5>
                            <p class="card-text text-muted mb-3">Buat permintaan bahan baku untuk kebutuhan memasak.</p>
                            <a href="{{ url('/dapur/permintaan') }}" class="btn btn-success mt-auto">
                                <i class="bi bi-plus-circle me-1"></i> Buat Permintaan
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card shadow-sm h-100">
                        <div class="card-body text-center d-flex flex-column justify-content-center">
                            <div class="icon-circle bg-warning-light mx-auto">
                                <i class="bi bi-clipboard-check"></i>
                            </div>
                            <h5 class="card-title">Status Permintaan</h5>
                            <p class="card-text text-muted mb-3">Lihat status permintaan: menunggu, disetujui, atau ditolak.</p>
                            <a href="{{ url('/dapur/status') }}" class="btn btn-warning mt-auto text-dark">
                                <i class="bi bi-eye me-1"></i> Lihat Status
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @else
            @yield('content')
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>