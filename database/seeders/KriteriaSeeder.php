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
            []

        ];

        foreach ($kriteria as $k) {
            Kriteria::create($k);
        }
    }
}