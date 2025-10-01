<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MBG - Gudang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-dark bg-primary">
        <div class="container">
            <span class="navbar-brand">MBG - Gudang</span>

            <!-- Menu di kanan -->
            <div class="d-flex">
                <a href="{{ url('/gudang/bahan') }}" class="btn btn-outline-light btn-sm me-2">
                    Kelola Bahan Baku
                </a>
                <a href="{{ url('/gudang/permintaan') }}" class="btn btn-outline-light btn-sm me-2">
                    Permintaan dari Dapur
                </a>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-link text-danger btn-sm"
                            onclick="return confirm('Yakin logout?')">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        @yield('content')
    </div>
</body>
</html>