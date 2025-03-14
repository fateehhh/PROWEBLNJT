<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanDetailSeeder extends Seeder
{
    public function run(): void
    {
        $barangData = [
            ['barang_id' => 1, 'harga_jual' => 60000],
            ['barang_id' => 2, 'harga_jual' => 32000],
            ['barang_id' => 3, 'harga_jual' => 15000],
            ['barang_id' => 4, 'harga_jual' => 10000],
            ['barang_id' => 5, 'harga_jual' => 13000],
            ['barang_id' => 6, 'harga_jual' => 18000],
            ['barang_id' => 7, 'harga_jual' => 10000],
            ['barang_id' => 8, 'harga_jual' => 30000],
            ['barang_id' => 9, 'harga_jual' => 37000],
            ['barang_id' => 10, 'harga_jual' => 45000],
        ];

        $penjualanDetails = [];
        $detailId = 1;

        // Loop untuk setiap transaksi (asumsi ada 10 transaksi)
        for ($penjualanId = 1; $penjualanId <= 10; $penjualanId++) {
            // Ambil 3 barang secara acak untuk transaksi ini
            $selectedBarang = collect($barangData)->random(3);

            foreach ($selectedBarang as $barang) {
                $penjualanDetails[] = [
                    'detail_id' => $detailId++,
                    'penjualan_id' => $penjualanId,
                    'barang_id' => $barang['barang_id'],
                    'harga' => $barang['harga_jual'],
                    'jumlah' => rand(1, 5), // Jumlah barang antara 1-5
                ];
            }
        }

        // Insert data ke dalam tabel
        DB::table('t_penjualan_detail')->insert($penjualanDetails);
    }
}
