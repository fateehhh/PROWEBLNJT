<?php

namespace App\Models; // Menentukan namespace 'App\Models' agar class ini dapat digunakan dengan mudah di seluruh aplikasi

use Illuminate\Database\Eloquent\Factories\HasFactory; // Menggunakan trait HasFactory untuk mendukung pembuatan instance model menggunakan factory
use Illuminate\Database\Eloquent\Model; // Menggunakan class Model sebagai dasar dari class Item agar dapat berinteraksi dengan database

class Item extends Model // Mendefinisikan class Item yang merupakan turunan dari Model
{
    use HasFactory; // Menggunakan trait HasFactory untuk mempermudah pembuatan data dummy dengan factory
    protected $fillable = [ 
        'name',
        'description',
    ]; // Menentukan kolom yang bisa diisi secara massal (mass assignment) untuk mencegah kerentanan keamanan.
}

