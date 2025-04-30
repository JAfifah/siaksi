<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class DokumenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('dokumens')->insert([
            [
                'user_id' => 1,
                'kriteria_id' => 1,
                'nama_dokumen' => 'Dokumen Contoh',
                'path' => 'path/to/file.pdf',
                'status' => 'menunggu',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
        
    }
}
