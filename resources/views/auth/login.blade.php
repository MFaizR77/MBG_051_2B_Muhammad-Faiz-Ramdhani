<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - MBG</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-success bg-gradient min-vh-100 d-flex align-items-center justify-content-center">

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-5 col-lg-4">

        <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
          <div class="card-header bg-success text-white text-center py-3">
            <h4 class="fw-semibold mb-0">
              <i class="bi bi-box-arrow-in-right me-2"></i>Login MBG
            </h4>
          </div>

          <div class="card-body bg-white p-4">
            @if(session('error'))
              <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}">
              @csrf

              <div class="mb-3">
                <label for="email" class="form-label fw-medium">Email</label>
                <input type="email" id="email" name="email" class="form-control form-control-lg rounded-3" required autofocus>
              </div>

              <div class="mb-4">
                <label for="password" class="form-label fw-medium">Password</label>
                <input type="password" id="password" name="password" class="form-control form-control-lg rounded-3" required>
              </div>

              <button type="submit" class="btn btn-success w-100 py-2 fw-semibold rounded-3">
                <i class="bi bi-door-open me-2"></i>Login
              </button>
            </form>
          </div>
        </div>

        <p class="text-center text-white mt-3 small">
          © 2025 MBG System. All rights reserved.
        </p>

      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
