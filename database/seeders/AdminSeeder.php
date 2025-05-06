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
            'name' => 'Atmin lur',
            'email' => 'admin@simsurat.com',
            'password' => Hash::make('admin123'),
            'is_superuser' => true,
            'is_active' => true,
        ];

        User::create($user);
    }
}
