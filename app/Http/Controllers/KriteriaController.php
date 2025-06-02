<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Komentar;
use App\Models\Dokumen;
use App\Models\Kriteria;

class KriteriaController extends Controller
{
    public function index()
    {
        $kriterias = Kriteria::all();
        $dokumen = Dokumen::all();
        $nomor = 1;

        return view('kriteria.kriteria', compact('kriterias', 'dokumen', 'nomor'));
    }

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

    public function lihat($nomor, $id)
    {
        logger()->info("Nomor diterima:", ['nomor' => $nomor]);
        logger()->info("ID kriteria yang diterima:", ['id' => $id]);

        $kriteria = Kriteria::findOrFail($id);
        $documents = Dokumen::where('kriteria_id', $id)->with('kriteria')->get();

        logger()->info('Dokumen ditemukan:', $documents->toArray());

        return view('kriteria.lihat', [
            'kriterias' => $kriteria,
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
            'judul' => 'required|string|max:255',
            'tahap' => 'required|string|max:50',
            'nomor' => 'required|string|max:255',
        ]);

        try {
            $kriteria = Kriteria::create([
                'nama' => $request->judul,
                'tahap' => $request->tahap,
                'nomor' => $request->nomor,
            ]);

            return redirect()->route('kriteria.show', $kriteria->nomor)
                ->with('success', 'Kriteria berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Gagal menambahkan kriteria: ' . $e->getMessage());

            return back()->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    public function storeWithDokumen(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'tahap' => 'required|string|max:50',
            'nomor' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,png,zip|max:2048',
            'link' => 'nullable|url',
            'status' => 'nullable|string|in:,dikirim',
        ]);

        // Validasi: setidaknya file atau link harus diisi
        if (!$request->hasFile('file') && empty($request->link)) {
            return back()
                ->withErrors(['file' => 'Harap unggah file atau isi link.'])
                ->withInput();
        }

        try {
            // Simpan data kriteria
            $kriteria = Kriteria::create([
                'nama' => $request->judul,
                'tahap' => $request->tahap,
                'nomor' => $request->nomor,
            ]);

            // Proses upload atau link dokumen
            $filePath = null;

            if ($request->hasFile('file')) {
                $uploadedFile = $request->file('file');
                $filename = time() . '_' . preg_replace('/\s+/', '_', $uploadedFile->getClientOriginalName());
                $uploadedFile->move(public_path('dokumen'), $filename);
                $filePath = $filename;
            } else {
                $filePath = $request->link;
            }

            // Simpan data dokumen
            Dokumen::create([
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi,
                'file_path' => $filePath,
                'tahap' => $request->tahap,
                'user_id' => auth()->id(),
                'kriteria_id' => $kriteria->id,
                'status' => $request->status ?: null,
            ]);

            return redirect()->route('kriteria.show', $kriteria->nomor)
                ->with('success', 'Kriteria dan dokumen berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan data: ' . $e->getMessage());

            return back()
                ->with('error', 'Terjadi kesalahan saat menyimpan data.')
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $kriteria = Kriteria::findOrFail($id);
            $kriteria->delete();

            return back()->with('success', 'Kriteria berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus kriteria: ' . $e->getMessage());

            return back()->with('error', 'Terjadi kesalahan saat menghapus kriteria.');
        }
    }

    public function edit($id)
    {
        $kriteria = Kriteria::findOrFail($id);

        return view('kriteria.editkriteria', compact('kriteria'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'tahap' => 'required|in:penetapan,pelaksanaan,evaluasi,pengendalian,peningkatan',
        ]);

        $kriteria = Kriteria::findOrFail($id);
        $kriteria->update($request->only('nama', 'tahap'));

        return redirect()->route('kriteria.index')->with('success', 'Kriteria berhasil diperbarui.');
    }
}
