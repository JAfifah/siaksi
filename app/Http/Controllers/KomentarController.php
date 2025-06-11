<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Komentar;
use Illuminate\Support\Facades\Auth;

class KomentarController extends Controller
{
    /**
     * Menyimpan komentar ke dalam database.
     */
    public function store(Request $request)
    {
        // Validasi input dari form
        $validated = $request->validate([
            'dokumen_id' => 'required|exists:dokumen,id',
            'isi' => 'required|string|max:1000', 
            'page' => 'nullable|integer', 
        ]);

        // Hanya admin, kajur, kps, dan direktur yang boleh komentar
        $allowedRoles = ['administrator', 'kajur', 'kps', 'direktur', 'koordinator'];
        $user = Auth::user();

        if (!in_array($user->role, $allowedRoles)) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk berkomentar.');
        }

        // Buat komentar baru
        $komentar = new Komentar();
        $komentar->dokumen_id = $validated['dokumen_id'];
        $komentar->user_id = $user->id; // Pastikan user sedang login
        $komentar->isi = $validated['isi'];
        $komentar->save();

        return redirect()->back()->with('success', 'Komentar berhasil dikirim.');
    }
}
