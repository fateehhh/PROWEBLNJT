<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PenjualanSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['penjualan_id' => 1, 'user_id' => 3, 'pembeli' => 'Budi Santoso', 'penjualan_kode' => Str::random(8), 'penjualan_tanggal' => Carbon::now()],
            ['penjualan_id' => 2, 'user_id' => 3, 'pembeli' => 'Siti Aminah', 'penjualan_kode' => Str::random(8), 'penjualan_tanggal' => Carbon::now()],
            ['penjualan_id' => 3, 'user_id' => 3, 'pembeli' => 'Ahmad Faisal', 'penjualan_kode' => Str::random(8), 'penjualan_tanggal' => Carbon::now()],
            ['penjualan_id' => 4, 'user_id' => 3, 'pembeli' => 'Dewi Lestari', 'penjualan_kode' => Str::random(8), 'penjualan_tanggal' => Carbon::now()],
            ['penjualan_id' => 5, 'user_id' => 3, 'pembeli' => 'Agus Prasetyo', 'penjualan_kode' => Str::random(8), 'penjualan_tanggal' => Carbon::now()],
            ['penjualan_id' => 6, 'user_id' => 3, 'pembeli' => 'Nina Susanti', 'penjualan_kode' => Str::random(8), 'penjualan_tanggal' => Carbon::now()],
            ['penjualan_id' => 7, 'user_id' => 3, 'pembeli' => 'Hendra Wijaya', 'penjualan_kode' => Str::random(8), 'penjualan_tanggal' => Carbon::now()],
            ['penjualan_id' => 8, 'user_id' => 3, 'pembeli' => 'Rina Marlina', 'penjualan_kode' => Str::random(8), 'penjualan_tanggal' => Carbon::now()],
            ['penjualan_id' => 9, 'user_id' => 3, 'pembeli' => 'Bagus Saputra', 'penjualan_kode' => Str::random(8), 'penjualan_tanggal' => Carbon::now()],
            ['penjualan_id' => 10, 'user_id' => 3, 'pembeli' => 'Citra Dewanti', 'penjualan_kode' => Str::random(8), 'penjualan_tanggal' => Carbon::now()],
        ];

        DB::table('t_penjualan')->insert($data);
    }
}
