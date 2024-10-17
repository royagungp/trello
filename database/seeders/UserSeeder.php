<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // akun admin
        User::create([
            'name' => 'Administrator',
            'email' => 'adminnaspad@gmail.com',
            'role' => 'admin',
            'password' => Hash::make('admin123'),
        ]);
        // akun kasir
        User::create([
            'name' => 'Kasir 1',
            'email' => 'kasirnaspad@gmail.com',
            'role' => 'kasir',
            'password' => Hash::make('kasir123'),
        ]);
    }
}