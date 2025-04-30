<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ValidasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('validasis')->insert([
            [
                'dokumen_id' => 1,
                'user_id' => 1,
                'status' => 'diterima',
                'created_at' => now(),
            ],
        ]);
        
    }
}
