<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'nama' => 'Admin Utama',
                'username' => 'admin',
                'password' => bcrypt('password'),
                'role' => 'administrator',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
        
    }
}
