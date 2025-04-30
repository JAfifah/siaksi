<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class KriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kriterias')->insert([
            [
                'nama_kriteria' => 'Kriteria A',
                'deskripsi' => 'Deskripsi A',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
        
    }
}
