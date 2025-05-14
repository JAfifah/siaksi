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
        $kriteria = [
            [
                'nama' => 'Statuta Polinema',
                'tahap' => 'penetapan',
                'nomor' => 1
            ]

        ];

        foreach ($kriteria as $k) {
            Kriteria::create($k);
    }
}
