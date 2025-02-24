<?php

namespace App\Http\Controllers; // Menentukan namespace 'App\Http\Controllers' agar class ini dapat digunakan dalam aplikasi

use App\Models\Item; // Menggunakan model Item untuk berinteraksi dengan tabel 'items' di database
use Illuminate\Http\Request; // Menggunakan class Request untuk menangani permintaan HTTP

class ItemController extends Controller // Mendefinisikan class ItemController yang merupakan turunan dari Controller
{
    public function index() // Method untuk menampilkan daftar item
    {
        $items = Item::all(); // Mengambil semua data dari tabel 'items'
        return view('items.index', compact('items')); // Mengembalikan view 'items.index' dengan data items
    }

    public function create() // Method untuk menampilkan halaman form tambah item
    {
        return view('items.create'); // Mengembalikan view 'items.create' yang berisi form input item baru
    }

    public function store(Request $request) // Method untuk menyimpan data item baru ke database
    {
        $request->validate([ // Melakukan validasi input
            'name' => 'required', // Field 'name' wajib diisi
            'description' => 'required', // Field 'description' wajib diisi
        ]);
         
        Item::create($request->only(['name', 'description'])); // Menyimpan data item ke dalam database
        return redirect()->route('items.index')->with('success', 'Item added successfully.'); // Redirect ke halaman index dengan pesan sukses
    }

    public function show(Item $item) // Method untuk menampilkan detail satu item berdasarkan ID
    {
        return view('items.show', compact('item')); // Mengembalikan view 'items.show' dengan data item
    }

    public function edit(Item $item) // Method untuk menampilkan halaman edit item
    {
        return view('items.edit', compact('item')); // Mengembalikan view 'items.edit' dengan data item
    }

    public function update(Request $request, Item $item) // Method untuk memperbarui data item di database
    {
        $request->validate([ // Melakukan validasi input
            'name' => 'required', // Field 'name' wajib diisi
            'description' => 'required', // Field 'description' wajib diisi
        ]);
         
        $item->update($request->only(['name', 'description'])); // Memperbarui data item dengan nilai yang baru
        return redirect()->route('items.index')->with('success', 'Item updated successfully.'); // Redirect ke halaman index dengan pesan sukses
    }

    public function destroy(Item $item) // Method untuk menghapus item dari database
    {
       $item->delete(); // Menghapus item dari database
       return redirect()->route('items.index')->with('success', 'Item deleted successfully.'); // Redirect ke halaman index dengan pesan sukses
    }
}
