<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dokumen;
use Illuminate\Support\Facades\Auth;
use App\Models\Kriteria;
use App\Models\Komentar;

class DokumenController extends Controller
{
    public function create()
    {
        $kriterias = Kriteria::all();
        return view('kriteria.upload', compact('kriterias'));
    }

    public function store(Request $request,)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'file' => 'required|file|mimes:pdf,doc,docx,jpg,png|max:2048',
            'kriteria_id' => 'required|exists:kriteria,id',
        ]);

        $uploadedFile = $request->file('file');
        $filename = time() . '_' . $uploadedFile->getClientOriginalName();
        $uploadedFile->move(public_path('dokumen'), $filename);
        $filePath = $filename;




        Dokumen::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'file_path' => $filePath,
            'user_id' => auth()->id(),
            'kriteria_id' => $request->kriteria_id,
        ]);

        return redirect()->back()->with('success', 'Dokumen berhasil diupload.');
    }

    public function showDokumen($id)
    {
        $dokumen = Dokumen::with('kriteria')->find($id);
        return view('kriteria.lihat', compact('dokumen'));
    }

    public function validasi($id)
    {
        // Ambil data dokumen berdasarkan ID
        $dokumen = Dokumen::with('kriteria')->find($id);

        // Tampilkan view walau dokumen null (biar tidak 404)
        return view('kriteria.validasi', compact('dokumen'));
    }

    public function kembalikan(Request $request, $id)
    {
        $request->validate([
            'komentar' => 'required|string|max:1000',
        ]);

        $dokumen = Dokumen::findOrFail($id);

        Komentar::create([
            'dokumen_id' => $dokumen->id,
            'user_id' => auth()->id(),
            'isi' => $request->komentar,
        ]);

        return redirect()->route('dokumen.validasi', $id)->with('error', 'Dokumen telah dikembalikan dengan komentar.');
    }
}
