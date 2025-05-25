<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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

    public function create(Request $request)
    {
        $tahap = $request->input('tahap');
        $nomor = $request->input('nomor');
        return view('kriteria.create', compact('tahap', 'nomor'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'tahap' => 'required|string|max:50',
            'nomor' => 'required|string|max:255'
        ]);

        try {
            $kriteria = new Kriteria();
            $kriteria->nama = $request->input('nama');
            $kriteria->tahap = $request->input('tahap');
            $kriteria->nomor = $request->input('nomor');
            $kriteria->save();

            return redirect()->route('kriteria.show', $kriteria->nomor)
                ->with('success', 'Kriteria berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Gagal menambahkan kriteria: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    public function destroy($id)
    {
        try {
            $kriteria = Kriteria::findOrFail($id);
            $kriteria->delete();

            return redirect()->back()->with('success', 'Kriteria berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus kriteria: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus kriteria.');
        }
    }
}
