<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('t_stok', function (Blueprint $table) {
            $table->id('stok_id');
            $table->unsignedBigInteger('barang_id')->index(); // Tambahkan kolom barang_id sebagai indexing dan foreign key
            $table->unsignedBigInteger('user_id')->index(); // Tambahkan kolom user_id sebagai indexing dan foreign key
            $table->integer('stok_tanggal');
            $table->integer('stok_jumlah');
            $table->timestamps();

            // Tambahkan constraint foreign key untuk kolom barang_id dan user_id
            $table->foreign('barang_id')->references('barang_id')->on('m_barang');
            $table->foreign('user_id')->references('user_id')->on('m_user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_stok');
    }
};
