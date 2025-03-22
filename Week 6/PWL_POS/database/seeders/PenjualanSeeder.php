<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'user_id' => 1,
                'pembeli' => 'Gilang Purnomo',
                'penjualan_kode' => 'TRX001',
                'tanggal_penjualan' => date('Y-m-d H:i:s', strtotime('2025-02-26')),
            ],
            [
                'user_id' => 2,
                'pembeli' => 'Alpin Rahman',
                'penjualan_kode' => 'TRX002',
                'tanggal_penjualan' => date('Y-m-d H:i:s', strtotime('2025-02-26')),
            ],
            [
                'user_id' => 3,
                'pembeli' => 'Satrio Nugroho',
                'penjualan_kode' => 'TRX003',
                'tanggal_penjualan' => date('Y-m-d H:i:s', strtotime('2025-02-27')),
            ],
            [
                'user_id' => 1,
                'pembeli' => 'Rizky Pratama',
                'penjualan_kode' => 'TRX004',
                'tanggal_penjualan' => date('Y-m-d H:i:s', strtotime('2025-02-27')),
            ],
            [
                'user_id' => 2,
                'pembeli' => 'Fajar Aditya',
                'penjualan_kode' => 'TRX005',
                'tanggal_penjualan' => date('Y-m-d H:i:s', strtotime('2025-02-28')),
            ],
            [
                'user_id' => 3,
                'pembeli' => 'Farhan Putra',
                'penjualan_kode' => 'TRX006',
                'tanggal_penjualan' => date('Y-m-d H:i:s', strtotime('2025-02-28')),
            ],
            [
                'user_id' => 1,
                'pembeli' => 'Citra Ayu',
                'penjualan_kode' => 'TRX007',
                'tanggal_penjualan' => date('Y-m-d H:i:s', strtotime('2025-02-29')),
            ],
            [
                'user_id' => 2,
                'pembeli' => 'Andi Kurniawan',
                'penjualan_kode' => 'TRX008',
                'tanggal_penjualan' => date('Y-m-d H:i:s', strtotime('2025-02-29')),
            ],
            [
                'user_id' => 3,
                'pembeli' => 'Fadillah Rahma',
                'penjualan_kode' => 'TRX009',
                'tanggal_penjualan' => date('Y-m-d H:i:s', strtotime('2025-03-01')),
            ],
            [
                'user_id' => 1,
                'pembeli' => 'Fikri Ramadhan',
                'penjualan_kode' => 'TRX010',
                'tanggal_penjualan' => date('Y-m-d H:i:s', strtotime('2025-03-02')),
            ]
        ];
        DB::table('t_penjualan')->insert($data);
    }
}
