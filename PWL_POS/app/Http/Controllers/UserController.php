<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(){
        // J4_Praktikum 1
        // $data = [
        //     'level_id' => 2,
        //     'username' => 'manager_tiga',
        //     'nama' => 'Manager 3',
        //     'password' => Hash::make('12345')
        // ];
        // UserModel::create($data);

        // $user = UserModel::all(); 
        // return view('user',['data' => $user]);

        // Praktikum 2.1 (no-3)
        // $user = UserModel::find(1);
        // return view('user',['data' => $user]);

        // Praktikum 2.1 (no-5)
        // $user = UserModel::where('level_id', 1)->first();
        // return view('user',['data' => $user]);

        // Praktikum 2.1 (no-7)
        // $user = UserModel::firstWhere('level_id', 1);
        // return view('user',['data' => $user]);

        // Praktikum 2.1 (no-9)
        // $user = UserModel::findOr(1, ['username','nama'], function(){
        //     abort(404);
        // });
        // return view('user',['data' => $user]);
        
        // Praktikum 2.1 (no-11)
        // (tidak menggunakan yang atas karena saya sudah memiliki datanya akibat auto incremet saat percobaan)
        // $user = UserModel::findOr(20, ['username','nama'], function(){
        //     abort(404);
        // });
        // return view('user',['data' => $user]);

        //(jadi saya menggunakan data lain yang tidak ada untuk menampilkan 404 Not Found)
        // $user = UserModel::findOr(30, ['username','nama'], function(){
        //     abort(404);
        // });
        // return view('user',['data' => $user]);

         // Praktikum 2.2 (no-2)
        // $user = UserModel::findOrFail(1);
        // return view('user',['data' => $user]);
        
        // Praktikum 2.2 (no-4)
        $user = UserModel::where('username','manager9')->firstOrFail();
        return view('user',['data' => $user]);
    }
}