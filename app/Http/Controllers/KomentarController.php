<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Komentar;
use Illuminate\Support\Facades\Auth;

class KomentarController extends Controller
{
    public function store(Request $request)
{
    $validated = $request->validate([
        'dokumen_id' => 'required|exists:dokumen,id',
        'isi' => 'required|string|max:1000', // Ganti dari 'komentar' menjadi 'isi'
    ]);

    $komentar = new Komentar();
    $komentar->dokumen_id = $validated['dokumen_id'];
    $komentar->user_id = auth()->id(); // Pastikan user sedang login
    $komentar->isi = $validated['isi']; // Ini sudah benar
    $komentar->save();

    return redirect()->back()->with('success', 'Komentar berhasil dikirim.');
}


}