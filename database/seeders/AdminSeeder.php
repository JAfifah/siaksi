<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = [
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'role' => 'administrator',
            'is_superuser' => true,
            'is_active' => true,
        ];

        $user = [
            'name' => 'Anggota',
            'email' => 'anggota@gmail.com',
            'password' => Hash::make('anggota123'),
            'role' => 'anggota',
            'is_superuser' => false,
            'is_active' => true,
        ];

        User::create($user);
    }
}
