<!DOCTYPE html>
<html>
<head>
    <title>Create Book</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5" style="max-width: 600px;">
        <h1 class="mb-4 text-center">Create New Book</h1>
        <form action="{{ route('books.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">Title:</label>
                <input type="text" id="title" name="title" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="author" class="form-label">Author:</label>
                <input type="text" id="author" name="author" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description:</label>
                <textarea id="description" name="description" class="form-control" required></textarea>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary w-50">Create Book</button>
                <a href="{{ route('books.index') }}" class="btn btn-secondary w-50">Kembali ke Halaman Utama</a>
            </div>
        </form>
    </div>
</body>
</html>
