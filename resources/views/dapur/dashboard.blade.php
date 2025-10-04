<!DOCTYPE html>
<html>

<head>
    <title>Dashboard Dapur - MBG</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-dark bg-success">
        <div class="container">
            <a href="{{ url('/dapur')}}" class="navbar-brand">MBG - Dapur</a>
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
                    <a href="{{ url('/dapur/permintaan') }}" class="list-group-item">Ajukan Permintaan</a>
                    <a href="{{ url('/dapur/status') }}" class="list-group-item">Status Permintaan</a>
                </div>
            </div>
            <div class="col-md-9">
                @yield('content')
            </div>
        </div>
    </div>
</body>

</html>