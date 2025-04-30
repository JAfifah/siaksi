<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class KomenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('komens')->insert([
            [
                'dokumen_id' => 1,
                'user_id' => 1,
                'komentar' => 'Komentar awal',
                'created_at' => now(),
            ],
        ]);
        
    }
}
