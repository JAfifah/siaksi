<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kriteria;

class KriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Menambahkan data kriteria ke dalam tabel 'kriteria'
        Kriteria::create(['nama' => 'Kriteria 1']);
        Kriteria::create(['nama' => 'Kriteria 2']);
        Kriteria::create(['nama' => 'Kriteria 3']);
        Kriteria::create(['nama' => 'Kriteria 4']);
        Kriteria::create(['nama' => 'Kriteria 5']);
    }
}
