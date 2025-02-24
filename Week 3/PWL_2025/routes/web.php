<?php

use App\Http\Controllers\ItemController; // Memanggil class ItemController
use Illuminate\Support\Facades\Route; // Memanggil class Route

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () { // Mendefinisikan route untuk halaman utama
    return view('welcome'); // Mengembalikan view 'welcome'
});

Route::resource('items', ItemController::class); // Mendefinisikan route untuk resource 'items'