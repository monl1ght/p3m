<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{

    public function run(): void
    {
        // User::create([
        //     'name' => 'Sujianim',
        //     'email' => 'sujia@gmail.com',
        //     'password' => Hash::make('11111111'), // hash make unutk enkripsi
        // ]);


    }
}
