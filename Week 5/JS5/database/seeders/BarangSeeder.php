<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['barang_id' => 1, 'kategori_id' => 1, 'barang_kode' => 'BRG001', 'barang_nama' => 'Beras 5kg', 'harga_beli' => 55000, 'harga_jual' => 60000],
            ['barang_id' => 2, 'kategori_id' => 1, 'barang_kode' => 'BRG002', 'barang_nama' => 'Minyak Goreng 2L', 'harga_beli' => 28000, 'harga_jual' => 32000],
            ['barang_id' => 3, 'kategori_id' => 2, 'barang_kode' => 'BRG003', 'barang_nama' => 'Keripik Kentang', 'harga_beli' => 12000, 'harga_jual' => 15000],
            ['barang_id' => 4, 'kategori_id' => 2, 'barang_kode' => 'BRG004', 'barang_nama' => 'Coklat Batangan', 'harga_beli' => 8000, 'harga_jual' => 10000],
            ['barang_id' => 5, 'kategori_id' => 3, 'barang_kode' => 'BRG005', 'barang_nama' => 'Teh Celup 25pcs', 'harga_beli' => 10000, 'harga_jual' => 13000],
            ['barang_id' => 6, 'kategori_id' => 3, 'barang_kode' => 'BRG006', 'barang_nama' => 'Kopi Instan 10s', 'harga_beli' => 15000, 'harga_jual' => 18000],
            ['barang_id' => 7, 'kategori_id' => 4, 'barang_kode' => 'BRG007', 'barang_nama' => 'Sabun Cuci Piring', 'harga_beli' => 7000, 'harga_jual' => 10000],
            ['barang_id' => 8, 'kategori_id' => 4, 'barang_kode' => 'BRG008', 'barang_nama' => 'Pewangi Pakaian 1L', 'harga_beli' => 25000, 'harga_jual' => 30000],
            ['barang_id' => 9, 'kategori_id' => 5, 'barang_kode' => 'BRG009', 'barang_nama' => 'Nugget Ayam 500g', 'harga_beli' => 32000, 'harga_jual' => 37000],
            ['barang_id' => 10, 'kategori_id' => 5, 'barang_kode' => 'BRG010', 'barang_nama' => 'Sosis Sapi 500g', 'harga_beli' => 40000, 'harga_jual' => 45000],
        ];

        DB::table('m_barang')->insert($data);
    }
}
