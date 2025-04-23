<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_supplier')->insert([
            [
                'supplier_kode' => 'SUP001',
                'supplier_nama' => 'PT Sumber Berkah',
                'supplier_alamat' => 'Jl. Merdeka No. 10, Jakarta',
                'supplier_telepon' => '081234567890',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'supplier_kode' => 'SUP002',
                'supplier_nama' => 'CV Maju Jaya',
                'supplier_alamat' => 'Jl. Mawar No. 15, Bandung',
                'supplier_telepon' => '082345678901',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'supplier_kode' => 'SUP003',
                'supplier_nama' => 'UD Sejahtera',
                'supplier_alamat' => 'Jl. Melati No. 20, Surabaya',
                'supplier_telepon' => '083456789012',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
