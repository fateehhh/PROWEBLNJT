<!DOCTYPE html>
<html>
<head>
    <title>Add Item</title> <!-- Menambahkan judul Add Item -->
</head>
<body>
    <h1>Add Item</h1> <!-- Menambahkan heading utama Add Item -->
    <form action="{{ route('items.store') }}" method="POST"> <!-- Menggunakan route items.store -->
        @csrf <!-- Menambahkan token CSRF -->
        <label for="name">Name:</label> <!-- Menambahkan label Name -->
        <input type="text" name="name" required> <!-- Menambahkan input Name -->
        <br>
        <label for="description">Description:</label> <!-- Menambahkan label Description -->
        <textarea name="description" required></textarea> <!-- Menambahkan textarea Description -->
        <br>
        <button type="submit">Add Item</button> <!-- Menambahkan tombol Add Item -->
    </form>
    <a href="{{ route('items.index') }}">Back to List</a> <!-- Menambahkan link Back to List -->
</body>
</html>