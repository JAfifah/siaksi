<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Komentar;


class KriteriaController extends Controller
{
    public function index()
    {
        $kriterias = [
            'kriteria_tabel_1' => [
                (object)['nama' => 'Kriteria 1A'],
                (object)['nama' => 'Kriteria 1B'],
            ],
        ];
        $komentars = Komentar::with('user')->get()->groupBy('table');

        return view('kriteria.kriteria1', compact('kriterias'));
        return view('kriteria.kriteria', compact('kriterias', 'komentars'));
    }

    public function upload($kriteria_id = null)
{
    return view('kriteria.upload', compact('kriteria_id'));
}

}
