<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Dokumen;
use App\Models\Kriteria;
use App\Models\Komentar;
use App\Models\User;
use App\Notifications\DocumentNotification;

class DokumenController extends Controller
{
    public function create()
    {
        if (!in_array(Auth::user()->role, ['administrator', 'anggota'])) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengunggah dokumen.');
        }

        $kriterias = Kriteria::all();
        return view('kriteria.create', compact('kriterias'));
    }

    public function createTemplate()
    {
        if (!in_array(Auth::user()->role, ['administrator', 'anggota'])) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin.');
        }

        $kriterias = Kriteria::all();
        return view('kriteria.template', compact('kriterias'));
    }

    public function store(Request $request)
    {
        if (!in_array(Auth::user()->role, ['administrator', 'anggota'])) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengunggah dokumen.');
        }

        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'isi' => 'nullable|string',
            'kriteria_id' => 'required|exists:kriteria,id',
            'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',
            'link' => 'nullable|url',
        ]);

        if (empty($request->isi) && !$request->hasFile('file') && !$request->link) {
            return redirect()->back()->withErrors(['file' => 'Harap isi konten, unggah file, atau isi link.'])->withInput();
        }

        $filePath = null;

        // Proses upload file
        if ($request->hasFile('file')) {
            $uploadedFile = $request->file('file');
            $namaFile = time() . '_' . $uploadedFile->getClientOriginalName();
            $uploadedFile->move(public_path('dokumen'), $namaFile);
            $filePath = $namaFile;
        } elseif ($request->link) {
            $filePath = $request->link;
        }

        $status = $request->status === 'draft' ? 'draft' : 'dikirim';

        $dokumen = Dokumen::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'isi' => $request->isi,
            'file_path' => $filePath,
            'user_id' => auth()->id(),
            'kriteria_id' => $request->kriteria_id,
            'status' => $status,
        ]);

        if ($status === 'dikirim') {
            $admins = User::where('role', 'administrator')->get();
            foreach ($admins as $admin) {
                $admin->notify(new DocumentNotification([
                    'title' => 'Dokumen Baru Diupload',
                    'message' => "Dokumen baru '{$request->judul}' telah diunggah",
                    'action_url' => route('kriteria.lihat', $dokumen->kriteria_id),
                    'document_id' => $dokumen->id
                ]));
            }
        }

        return redirect()->back()->with('success', 'Dokumen berhasil disimpan.');
    }

    public function edit($id)
    {
        $dokumen = Dokumen::findOrFail($id);
        return view('kriteria.edit', compact('dokumen'));
    }

    public function update(Request $request, $id)
    {
        $dokumen = Dokumen::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'isi' => 'nullable|string',
            'kriteria_id' => 'required|exists:kriteria,id',
            'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,png,zip|max:4096',
            'link' => 'nullable|url',
        ]);

        if (empty($request->isi) && !$request->hasFile('file') && !$request->link && !$dokumen->file_path) {
            return redirect()->back()->withErrors(['file' => 'Harap isi konten, unggah file, atau isi link.'])->withInput();
        }

        $filePath = $dokumen->file_path;

        if ($request->hasFile('file')) {
            // Hapus file lama jika ada dan bukan URL
            if ($dokumen->file_path && !filter_var($dokumen->file_path, FILTER_VALIDATE_URL)) {
                $oldFile = public_path('dokumen/' . $dokumen->file_path);
                if (file_exists($oldFile)) {
                    unlink($oldFile);
                }
            }

            $uploadedFile = $request->file('file');
            $namaFile = time() . '_' . $uploadedFile->getClientOriginalName();
            $uploadedFile->move(public_path('dokumen'), $namaFile);
            $filePath = $namaFile;
        } elseif ($request->link) {
            $filePath = $request->link;
        }

        $status = $request->input('action') === 'submit' ? 'dikirim' :
                  ($request->input('action') === 'save' ? 'draft' : $dokumen->status);

        $dokumen->update([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'konten' => $request->isi,
            'file_path' => $filePath,
            'kriteria_id' => $request->kriteria_id,
            'status' => $status,
        ]);

        $redirectUrl = $request->input('redirect_url', url('/'));
        return redirect($redirectUrl)->with('success', 'Dokumen berhasil diperbarui.');
    }

    public function showDokumen($id)
    {
        $kriteria = Kriteria::findOrFail($id);
        $documents = Dokumen::where('kriteria_id', $id)->with(['komentars.user'])->get();
        return view('kriteria.lihat', compact('documents', 'kriteria'));
    }

    public function validasi($id)
    {
        $dokumen = Dokumen::with(['kriteria', 'komentars.user'])->findOrFail($id);
        return view('kriteria.validasi', compact('dokumen'));
    }

    public function kembalikan(Request $request, $id)
    {
        $dokumen = Dokumen::findOrFail($id);

        $request->validate([
            'komentar' => 'nullable|string',
        ]);

        $dokumen->status = 'dikembalikan';
        $dokumen->komentar_pengembalian = $request->komentar;
        $dokumen->save();

        if ($request->filled('komentar')) {
            Komentar::create([
                'user_id' => Auth::id(),
                'dokumen_id' => $dokumen->id,
                'isi' => $request->komentar,
            ]);
        }

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

        $dokumen->user->notify(new DocumentNotification([
            'title' => 'Dokumen Disetujui',
            'message' => "Dokumen Anda '{$dokumen->judul}' telah disetujui",
            'action_url' => route('dokumen.lihat', $dokumen->id),
            'document_id' => $dokumen->id
        ]));

        return redirect()->back()->with('success', 'Dokumen berhasil disetujui.');
    }

    public function createFromTemplate()
    {
        $kriterias = Kriteria::all();
        return view('dokumen.create', compact('kriterias'));
    }

    public function destroy($kriteriaId)
    {
        $dokumen = Dokumen::where('kriteria_id', $kriteriaId)->first();
        if ($dokumen) {
            $dokumen->delete();
        }

        $kriteria = Kriteria::find($kriteriaId);
        if ($kriteria) {
            $kriteria->delete();
        }

        return redirect()->back()->with('success', 'Dokumen dan kriteria berhasil dihapus.');
    }

    public function storeFromTemplate(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'isi' => 'required|string',
            'tahap' => 'required|string',
            'kriteria_id' => 'required|integer',
            'status' => 'required|in:draft,dikirim',
        ]);

        $dokumen = Dokumen::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'isi' => $request->isi,
            'tahap' => $request->tahap,
            'kriteria_id' => $request->kriteria_id,
            'status' => $request->status,
            'user_id' => auth()->id(),
        ]);

        return response()->json([
            'message' => 'Dokumen berhasil disimpan!',
            'redirect' => route('kriteria.index')
        ]);
    }
}
