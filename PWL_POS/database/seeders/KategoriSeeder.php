<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['kategori_id' => 1, 'kategori_kode' => 'GRK', 'kategori_nama' => 'Groceries'],
            ['kategori_id' => 2, 'kategori_kode' => 'SNK', 'kategori_nama' => 'Snacks'],
            ['kategori_id' => 3, 'kategori_kode' => 'DRK', 'kategori_nama' => 'Drinks'],
            ['kategori_id' => 4, 'kategori_kode' => 'HHP', 'kategori_nama' => 'Household Products'],
            ['kategori_id' => 5, 'kategori_kode' => 'FRZ', 'kategori_nama' => 'Frozen Foods'],
        ];

        DB::table('m_kategori')->insert($data);
    }
}
