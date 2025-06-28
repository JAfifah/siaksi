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
        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin123'),
                'role' => 'administrator',
                'is_superuser' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Anggota',
                'email' => 'anggota@gmail.com',
                'password' => Hash::make('anggota123'),
                'role' => 'anggota',
                'is_superuser' => false,
                'is_active' => true,
            ],
            [
                'name' => 'Koordinator',    
                'email' => 'koordinator@gmail.com',
                'password' => Hash::make('koordinator123'),
                'role' => 'koordinator',
                'is_superuser' => false,
                'is_active' => true,
            ],
            [
                'name' => 'KPS',
                'email' => 'kps@gmail.com',
                'password' => Hash::make('kps123'),
                'role' => 'kps',
                'is_superuser' => false,
                'is_active' => true,
            ],
            [
                'name' => 'Kajur',
                'email' => 'kajur@gmail.com',
                'password' => Hash::make('kajur123'),
                'role' => 'kajur',
                'is_superuser' => false,
                'is_active' => true,
            ],
            [
                'name' => 'KJM',
                'email' => 'kjm@gmail.com',
                'password' => Hash::make('kjm123'),
                'role' => 'kjm',
                'is_superuser' => false,
                'is_active' => true,
            ],
            [
                'name' => 'Direktur',
                'email' => 'direktur@gmail.com',
                'password' => Hash::make('direktur123'),
                'role' => 'direktur',
                'is_superuser' => false,
                'is_active' => true,
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}