<!DOCTYPE html>
<html>
<head>
    <title>Edit Item</title> <!-- Menambahkan judul Edit Item -->
</head>
<body>
    <h1>Edit Item</h1> <!-- Menambahkan heading utama Edit Item -->
    <form action="{{ route('items.update', $item) }}" method="POST"> <!-- Membuka form dengan method POST yang mengarah ke route 'items.update' untuk item tertentu -->
        @csrf <!-- Menambahkan token CSRF yang digunakan untuk mencegah serangan Cross-Site Request Forgery -->
        @method('PUT') <!-- Mengubah metode form dari POST menjadi PUT, karena update data biasanya menggunakan metode PUT atau PATCH -->
        <label for="name">Name:</label> <!-- Label untuk input field nama item -->
        <input type="text" name="name" value="{{ $item->name }}" required><!-- Input field untuk nama item, dengan nilai default diisi dari data item yang sedang diedit dan wajib diisi -->
        <br>
        <label for="description">Description:</label> <!-- Label untuk input field deskripsi item -->
        <textarea name="description" required>{{ $item->description }}</textarea> <!-- Input field untuk deskripsi item, dengan nilai default diisi dari data item yang sedang diedit dan wajib diisi -->
        <br>
        <button type="submit">Update Item</button> <!-- Tombol untuk mengirimkan form -->
    </form>
    <a href="{{ route('items.index') }}">Back to List</a> <!-- Tombol untuk kembali ke halaman daftar item -->
</body>
</html>