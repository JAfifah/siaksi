<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Komentar;
use App\Models\Dokumen;
use Illuminate\Support\Facades\Auth;
use App\Notifications\DocumentNotification;

class KomentarController extends Controller
{
    /**
     * Menyimpan komentar ke dalam database dan mengirim notifikasi ke pemilik dokumen.
     */
    public function store(Request $request)
    {
        // Validasi input dari form
        $validated = $request->validate([
            'dokumen_id' => 'required|exists:dokumen,id',
            'isi' => 'required|string|max:1000', 
            'page' => 'nullable|integer', 
        ]);

        // Hanya admin, kajur, kps, direktur, koordinator yang boleh komentar
        $allowedRoles = ['administrator', 'kajur', 'kps', 'direktur', 'koordinator'];
        $user = Auth::user();

        if (!in_array($user->role, $allowedRoles)) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk berkomentar.');
        }

        // Buat komentar baru
        $komentar = new Komentar();
        $komentar->dokumen_id = $validated['dokumen_id'];
        $komentar->user_id = $user->id;
        $komentar->isi = $validated['isi'];
        $komentar->save();

        // Kirim notifikasi ke pemilik dokumen (jika bukan dirinya sendiri)
        $dokumen = Dokumen::find($validated['dokumen_id']);
        if ($dokumen && $dokumen->user_id != $user->id) {
            $dokumen->user->notify(new DocumentNotification([
                'title' => 'Komentar Baru',
                'message' => "Ada komentar baru pada dokumen '{$dokumen->judul}'",
                'action_url' => route('dokumen.lihat', $dokumen->id),
                'document_id' => $dokumen->id,
                'icon' => 'comments'
            ]));
        }

        return redirect()->back()->with('success', 'Komentar berhasil dikirim.');
    }
}