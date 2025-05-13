<?php

namespace App\Http\Controllers;

use Dom\Document;
use Illuminate\Http\Request;
use App\Models\Komentar;
use App\Models\Dokumen;
use App\Models\Kriteria;

class KriteriaController extends Controller
{
    public function index()
    {
        $kriterias = Kriteria::all()->groupBy('table');

        $komentars = Komentar::with('user')->get()->groupBy('table');

        $dokumen = Dokumen::all();

        return view('kriteria.kriteria1', [
            'kriterias' => $kriterias,
            'komentars' => $komentars,
            'dokumen' => $dokumen,
        ]);
    }

    public function lihat($id)
    {
        $kriterias = Kriteria::find($id);

        // Ambil semua dokumen berdasarkan kriteria_id
        $documents = Dokumen::where('kriteria_id', $id)->with('kriteria')->get();

        return view('kriteria.lihat', [
            'kriterias' => $kriterias,
            'documents' => $documents,
        ]);
    }

    public function upload($id = null)
    {
        $kriteria = Kriteria::all();
        return view('kriteria.upload', compact('kriteria', 'id'));
    }
}
