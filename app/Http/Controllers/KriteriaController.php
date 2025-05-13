<?php

namespace App\Http\Controllers;

<<<<<<< HEAD
use Dom\Document;
use Illuminate\Http\Request;
use App\Models\Komentar;
use App\Models\Dokumen;
use App\Models\Kriteria; // tambahkan ini
=======
use Illuminate\Http\Request;
use App\Models\Komentar;

>>>>>>> 2e8eb87c39bff4f296f17a31cb9684ef9f627139

class KriteriaController extends Controller
{
    public function index()
    {
<<<<<<< HEAD
        $kriterias = Kriteria::all();

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
    
    

    public function upload($id)
    {

        $kriteria = Kriteria::all();
        return view('kriteria.upload', compact('kriteria', 'id'));
    }
=======
        $kriterias = [
            'kriteria_tabel_1' => [
                (object)['nama' => 'Kriteria 1A'],
                (object)['nama' => 'Kriteria 1B'],
            ],
        ];
        $komentars = Komentar::with('user')->get()->groupBy('table');

        return view('kriteria.kriteria1', compact('kriterias'));
        return view('kriteria.kriteria2', compact('kriterias'));
        return view('kriteria.kriteria', compact('kriterias', 'komentars'));
    }

    public function upload($kriteria_id = null)
{
    return view('kriteria.upload', compact('kriteria_id'));
}

>>>>>>> 2e8eb87c39bff4f296f17a31cb9684ef9f627139
}
