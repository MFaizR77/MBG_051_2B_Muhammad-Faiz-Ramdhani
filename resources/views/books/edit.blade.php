<!DOCTYPE html>
<html>

<head>
    <title>Edit Book</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4">Edit Book</h1>
        <form action="{{ route('books.update', $book->id) }}" method="POST" class="card p-4 shadow-sm">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="title" class="form-label">Title:</label>
                <input type="text" name="title" id="title" value="{{ old('title', $book->title) }}" required class="form-control">
            </div>
            <div class="mb-3">
                <label for="author" class="form-label">Author:</label>
                <input type="text" name="author" id="author" value="{{ old('author', $book->author) }}" required class="form-control">
            </div>
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi:</label>
                <textarea name="deskripsi" id="deskripsi" required class="form-control">{{ old('deskripsi', $book->deskripsi) }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update Book</button>
        </form>
    </div>
</body>

</html>