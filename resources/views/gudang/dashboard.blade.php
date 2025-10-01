<!DOCTYPE html>
<html>

<head>
    <title>Dashboard Gudang - MBG</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-dark bg-primary">
        <div class="container">
            <span class="navbar-brand">MBG - Gudang</span>
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-link text-danger" onclick="return confirm('Yakin ingin logout?')">
                    Logout
                </button>
            </form>
        </div>
    </nav>

    <div class="container mt-4">
        <h2>Selamat Datang, {{ session('name') }}</h2>
        <div class="row mt-4">
            <div class="col-md-3">
                <div class="list-group">
                    <a href="{{ url('/gudang/bahan') }}" class="list-group-item">Kelola Bahan Baku</a>
                    <a href="{{ url('/gudang/permintaan') }}" class="list-group-item">Permintaan dari Dapur</a>
                </div>
            </div>
            <div class="col-md-9">
                @yield('content')
            </div>
        </div>
    </div>
</body>

</html>