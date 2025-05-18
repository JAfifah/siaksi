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
        // Validasi awal
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'kriteria_id' => 'required|exists:kriteria,id',
            'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',
            'link' => 'nullable|url',
        ]);

        // Validasi minimal salah satu harus diisi
        if (!$request->hasFile('file') && !$request->link) {
            return redirect()->back()->withErrors(['file' => 'Harap unggah file atau isi link.'])->withInput();
        }

        $filePath = null;

        if ($request->hasFile('file')) {
            $uploadedFile = $request->file('file');
            $filename = time() . '_' . $uploadedFile->getClientOriginalName();
            $uploadedFile->move(public_path('dokumen'), $filename);
            $filePath = $filename;
        } else {
            $filePath = $request->link;
        }

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
    $dokumen = Dokumen::findOrFail($id);

    // Validasi komentar (optional)
    $request->validate([
        'komentar' => 'nullable|string',
    ]);

    // Logika pengembalian dokumen, misalnya update status dan simpan komentar
    $dokumen->status = 'dikembalikan';
    $dokumen->komentar_pengembalian = $request->komentar;
    $dokumen->save();

    return redirect()->back()->with('success', 'Dokumen berhasil dikembalikan.');
}


    public function setujui($id)
    {
        $dokumen = Dokumen::findOrFail($id);
        $dokumen->status = 'disetujui';
        $dokumen->save();

        return redirect()->back()->with('success', 'Dokumen berhasil disetujui.');
    }
}
