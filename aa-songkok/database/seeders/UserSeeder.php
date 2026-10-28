<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'     => 'Admin AA Songkok',
            'email'    => 'admin@aasongkok.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
            'phone'    => '081234567890',
            'address'  => 'Jl. Songkok No. 1, Jakarta Pusat',
        ]);

        User::create([
            'name'     => 'Ahmad Budi',
            'email'    => 'user@aasongkok.com',
            'password' => Hash::make('password'),
            'role'     => 'user',
            'phone'    => '082345678901',
            'address'  => 'Jl. Melati No. 5, Bandung',
        ]);

        User::create([
            'name'     => 'Siti Rahayu',
            'email'    => 'siti@example.com',
            'password' => Hash::make('password'),
            'role'     => 'user',
            'phone'    => '083456789012',
            'address'  => 'Jl. Mawar No. 10, Surabaya',
        ]);

        User::create([
            'name'     => 'Muhammad Rizky',
            'email'    => 'rizky@example.com',
            'password' => Hash::make('password'),
            'role'     => 'user',
            'phone'    => '084567890123',
            'address'  => 'Jl. Anggrek No. 15, Yogyakarta',
        ]);
    }
}
