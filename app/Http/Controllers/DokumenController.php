<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document; // pastikan model ini sudah dibuat
use Illuminate\Support\Facades\Auth;

class DokumenController extends Controller
{
    public function create()
    {
        return view('kriteria.upload'); // Menampilkan form upload dari views/kriteria/upload.blade.php
    }
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'file' => 'required|file|mimes:pdf,doc,docx,jpg,png|max:2048',
        ]);

        $filePath = $request->file('file')->store('dokumen', 'public');

        Document::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'file_path' => $filePath,
            'user_id' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Dokumen berhasil diupload.');
    }
}
