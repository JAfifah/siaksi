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

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'file' => 'required|file|mimes:pdf,doc,docx,jpg,png|max:2048',
            'kriteria_id' => 'required|exists:kriteria,id',
        ]);

        $path = $request->file('file')->store('dokumen', 'public');

        $uploadedFile = $request->file('file');
        $filename = time() . '_' . $uploadedFile->getClientOriginalName();
        $uploadedFile->move(public_path('dokumen'), $filename);
        $filePath = $filename;

        // Menyimpan dokumen ke database
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
        $dokumen = Dokumen::with('kriteria')->find($id); // Pastikan relasi 'kriteria' ada
        return view('kriteria.validasi', compact('dokumen'));
    }

    public function kembalikan(Request $request, $id)
    {
        $request->validate([
            'komentar' => 'required|string|max:1000',
        ]);

        $dokumen = Dokumen::find($id);

        if ($dokumen) {
            // Menandai dokumen dengan status 'ditolak' atau apapun sesuai kebutuhan
            $dokumen->status = 'ditolak'; // Jika ada field status
            $dokumen->save();

            // Simpan komentar jika ada relasi komentar
            $dokumen->komentars()->create([
                'user_id' => auth()->id(),
                'isi' => $request->komentar,
            ]);

            return redirect()->route('dokumen.validasi', $id)->with('success', 'Dokumen berhasil dikembalikan dengan komentar.');
        }

        return redirect()->back()->with('error', 'Dokumen tidak ditemukan.');
    }

    public function setujui($id)
    {
        $dokumen = Dokumen::findOrFail($id);
        $dokumen->status = 'disetujui';
        $dokumen->save();

        return redirect()->back()->with('success', 'Dokumen berhasil disetujui.');
    }

}
