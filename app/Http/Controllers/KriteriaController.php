<?php

namespace App\Http\Controllers;

use Dom\Document;
use Illuminate\Http\Request;
use App\Models\Komentar;
use App\Models\Dokumen;
use App\Models\Kriteria;

class KriteriaController extends Controller
{
    public function show($nomor)
    {
        $kriterias = Kriteria::where('nomor', $nomor)->get();
        $dokumen = Dokumen::all();
        $komentars = Komentar::where('page', $nomor)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('kriteria.kriteria', compact('kriterias', 'dokumen', 'komentars', 'nomor'));
    }

    public function lihat($id)
    {
        $kriterias = Kriteria::find($id);
        $documents = Dokumen::where('kriteria_id', $id)->with('kriteria')->get();

        return view('kriteria.lihat', [
            'kriterias' => $kriterias,
            'documents' => $documents,
        ]);
    }

    public function upload($id)
    {
        $kriteria = Kriteria::all();
        return view('kriteria.upload', compact('kriteria', 'id'));
    }
}