<?php

use Illuminate\Database\Migrations\Migration; // Menggunakan class Migration dari Laravel untuk membuat perubahan database
use Illuminate\Database\Schema\Blueprint; // Menggunakan class Blueprint untuk mendefinisikan struktur tabel
use Illuminate\Support\Facades\Schema; // Menggunakan Schema untuk menjalankan operasi pembuatan dan penghapusan tabel

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void //Method ini akan dijalankan saat migration dijalankan
    {
        Schema::create('items', function (Blueprint $table) { // Membuat tabel 'items' dengan struktur yang didefinisikan dalam callback function
            $table->id(); // Menambahkan kolom 'id' sebagai primary key dengan auto-increment
            $table->string('name'); // Menambahkan kolom 'name' bertipe string
            $table->string('description'); // Menambahkan kolom 'description' bertipe string
            $table->timestamps(); // Menambahkan kolom 'created_at' dan 'updated_at' secara otomatis
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items'); // Menghapus tabel 'items' jika ada
    }
};
