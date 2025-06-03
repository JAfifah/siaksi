<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dokumen;
use Illuminate\Support\Facades\Auth;
use App\Models\Kriteria;
use App\Models\Komentar;
use App\Notifications\DocumentNotification;
use App\Models\User;

class DokumenController extends Controller
{
    public function create()
    {
        // Cek role user, hanya admin dan anggota yang diizinkan
        if (!in_array(Auth::user()->role, ['administrator', 'anggota'])) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengunggah dokumen.');
        }

        $kriterias = Kriteria::all();
        return view('kriteria.upload', compact('kriterias'));
    }

    public function store(Request $request)
    {
        // Cek role user, hanya admin dan anggota yang diizinkan
        if (!in_array(Auth::user()->role, ['administrator', 'anggota'])) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengunggah dokumen.');
        }

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

        // ✅ Tentukan status berdasarkan tombol yang diklik
        $status = $request->has('draft') ? 'draft' : 'dikirim';

        // Menyimpan dokumen ke database
        $dokumen = Dokumen::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'file_path' => $filePath,
            'user_id' => auth()->id(),
            'kriteria_id' => $request->kriteria_id,
            'status' => $status,
        ]);

        // Notify relevant users (e.g., admins)
        $admins = User::where('role', 'administrator')->get();
        foreach ($admins as $admin) {
            $admin->notify(new DocumentNotification([
                'title' => 'Dokumen Baru Diupload',
                'message' => "Dokumen baru '{$request->judul}' telah diunggah",
                'action_url' => route('kriteria.lihat', $dokumen->kriteria_id),
                'document_id' => $dokumen->id
            ]));
        }

        return redirect()->back()->with('success', 'Dokumen berhasil diupload.');
    }

    public function edit($id)
    {
        $dokumen = Dokumen::findOrFail($id);
        return view('kriteria.edit', compact('dokumen'));
    }

    public function update(Request $request, $id)
    {
        // Cari dokumen berdasarkan ID
        $dokumen = Dokumen::findOrFail($id);

        // Validasi input
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'kriteria_id' => 'required|exists:kriteria,id',
            'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,png,zip|max:4096',
            'link' => 'nullable|url',
        ]);

        // Validasi minimal salah satu harus diisi (file baru, link, atau file lama masih ada)
        if (!$request->hasFile('file') && !$request->link && !$dokumen->file_path) {
            return redirect()->back()
                ->withErrors(['file' => 'Harap unggah file atau isi link.'])
                ->withInput();
        }

        $filePath = $dokumen->file_path;

        if ($request->hasFile('file')) {
            // Hapus file lama jika sebelumnya adalah file (bukan link)
            if ($dokumen->file_path && !filter_var($dokumen->file_path, FILTER_VALIDATE_URL)) {
                $oldFile = public_path('dokumen/' . $dokumen->file_path);
                if (file_exists($oldFile)) {
                    unlink($oldFile);
                }
            }

            // Simpan file baru
            $uploadedFile = $request->file('file');
            $filename = time() . '_' . $uploadedFile->getClientOriginalName();
            $uploadedFile->move(public_path('dokumen'), $filename);
            $filePath = $filename;
        } elseif ($request->link) {
            // Jika hanya link yang diisi
            $filePath = $request->link;
        }

        // Tentukan status berdasarkan tombol yang diklik (action)
        $status = null;
        if ($request->input('action') === 'submit') {
            $status = 'dikirim';
        } elseif ($request->input('action') === 'save') {
            $status = null;
        }

        // Update dokumen
        $dokumen->update([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'file_path' => $filePath,
            'kriteria_id' => $request->kriteria_id,
            'status' => $status,
        ]);

        $redirectUrl = $request->input('redirect_url', url('/')); // fallback ke homepage kalau kosong

        return redirect($redirectUrl)->with('success', 'Dokumen berhasil diperbarui.');
    }

    public function showDokumen($id)
    {
        $kriteria = Kriteria::findOrFail($id);
        $documents = Dokumen::where('kriteria_id', $id)->with(['komentars.user'])->get();
        $kriterias = $kriteria; // Keep this for backward compatibility

        return view('kriteria.lihat', compact('documents', 'kriterias'));

    }

    public function validasi($id)
    {
        // Load dokumen, relasi kriteria dan komentar beserta user komentarnya
        $dokumen = Dokumen::with(['kriteria', 'komentars.user'])->find($id);
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

        // Simpan komentar juga ke tabel komentar (opsional)
        if ($request->filled('komentar')) {
            Komentar::create([
                'user_id' => Auth::id(),
                'dokumen_id' => $dokumen->id,
                'isi' => $request->komentar,
            ]);
        }

        // Notify document owner (kembalikan)
        $dokumen->user->notify(new DocumentNotification([
            'title' => 'Dokumen Dikembalikan',
            'message' => "Dokumen Anda '{$dokumen->judul}' telah dikembalikan untuk revisi",
            'action_url' => route('dokumen.edit', $dokumen->id),
            'document_id' => $dokumen->id
        ]));

        return redirect()->back()->with('success', 'Dokumen berhasil dikembalikan.');
    }

    public function setujui($id)
    {
        $dokumen = Dokumen::findOrFail($id);
        $dokumen->status = 'disetujui';
        $dokumen->save();

        // Notify document owner (setujui)
        $dokumen->user->notify(new DocumentNotification([
            'title' => 'Dokumen Disetujui',
            'message' => "Dokumen Anda '{$dokumen->judul}' telah disetujui",
            'action_url' => route('dokumen.lihat', $dokumen->id),
            'document_id' => $dokumen->id
        ]));

        return redirect()->back()->with('success', 'Dokumen berhasil disetujui.');
    }
}
