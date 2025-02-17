<!DOCTYPE html>
<html>
<head>
    <title>Item List</title> <!-- Membuat tittle 'Item List' -->
</head>
<body>
    <h1>Items</h1> <!-- Menampilkan heading utama 'Items' -->

    @if(session('success')) <!-- Mengecek apakah ada pesan sukses yang disimpan dalam session -->
        <p>{{ session('success') }}</p> <!-- Menampilkan pesan sukses jika ada -->
    @endif

    <a href="{{ route('items.create') }}">Add Item</a> <!-- Link untuk menuju halaman tambah item -->

    <ul> <!-- Membuka elemen  list untuk menampilkan daftar item -->
        @foreach ($items as $item) <!-- Melakukan looping pada semua item yang dikirim dari controller -->
            <li> <!-- Membuka elemen list untuk setiap item -->
                {{ $item->name }} - <!-- Menampilkan nama item -->

                <a href="{{ route('items.edit', $item) }}">Edit</a> <!-- Link untuk mengedit item -->

                <form action="{{ route('items.destroy', $item) }}" method="POST" style="display:inline;"> 
                    <!-- Form untuk menghapus item, menggunakan metode POST -->
                    @csrf <!-- Menambahkan token CSRF untuk keamanan -->
                    @method('DELETE') <!-- Menggunakan metode DELETE untuk menghapus item -->
                    <button type="submit">Delete</button> <!-- Tombol untuk menghapus item -->
                </form>
            </li> <!-- Menutup elemen list -->
        @endforeach <!-- Menutup perulangan foreach -->
    </ul> <!-- Menutup elemen list -->

</body>
</html>