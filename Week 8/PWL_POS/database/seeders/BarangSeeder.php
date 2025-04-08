<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            // Kategori 1: Bayi & Anak-anak
            [
                'kategori_id' => 1,
                'barang_kode' => 'B001',
                'barang_nama' => 'Popok Bayi',
                'harga_beli' => 30000,
                'harga_jual' => 40000,
            ],
            [
                'kategori_id' => 1,
                'barang_kode' => 'B002',
                'barang_nama' => 'Susu Formula',
                'harga_beli' => 70000,
                'harga_jual' => 85000,
            ],

            // Kategori 2: Kecantikan & Kesehatan
            [
                'kategori_id' => 2,
                'barang_kode' => 'B003',
                'barang_nama' => 'Sabun Herbal',
                'harga_beli' => 15000,
                'harga_jual' => 20000,
            ],
            [
                'kategori_id' => 2,
                'barang_kode' => 'B004',
                'barang_nama' => 'Shampoo Anti Ketombe',
                'harga_beli' => 25000,
                'harga_jual' => 35000,
            ],

            // Kategori 3: Makanan & Minuman
            [
                'kategori_id' => 3,
                'barang_kode' => 'B005',
                'barang_nama' => 'Biskuit Gandum',
                'harga_beli' => 10000,
                'harga_jual' => 15000,
            ],
            [
                'kategori_id' => 3,
                'barang_kode' => 'B006',
                'barang_nama' => 'Minuman Kopi Golda',
                'harga_beli' => 3500,
                'harga_jual' => 5000,
            ],

            // Kategori 4: Perawatan Rumah
            [
                'kategori_id' => 4,
                'barang_kode' => 'B007',
                'barang_nama' => 'Deterjen Cair',
                'harga_beli' => 25000,
                'harga_jual' => 35000,
            ],
            [
                'kategori_id' => 4,
                'barang_kode' => 'B008',
                'barang_nama' => 'Pembersih Lantai',
                'harga_beli' => 15000,
                'harga_jual' => 17000,
            ],

            // Kategori 5: Elektronik
            [
                'kategori_id' => 5,
                'barang_kode' => 'B009',
                'barang_nama' => 'Rice Cooker',
                'harga_beli' => 300000,
                'harga_jual' => 350000,
            ],
            [
                'kategori_id' => 5,
                'barang_kode' => 'B010',
                'barang_nama' => 'Kipas Angin',
                'harga_beli' => 160000,
                'harga_jual' => 200000,
            ]
        ];
        DB::table('m_barang')->insert($data);
    }
}
