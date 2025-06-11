<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Komentar;
use App\Models\Dokumen;
use App\Models\Kriteria;

class KriteriaController extends Controller
{
    // Tampilkan semua kriteria
    public function index()
    {
        $kriterias = Kriteria::all();
        $dokumen = Dokumen::all();
        $nomor = 1;

        return view('kriteria.kriteria', compact('kriterias', 'dokumen', 'nomor'));
    }

    // Tampilkan kriteria berdasarkan nomor halaman
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

    // Lihat detail kriteria dan dokumen terkait
    public function lihat($nomor, $id)
    {
        logger()->info("Nomor diterima:", ['nomor' => $nomor]);
        logger()->info("ID kriteria yang diterima:", ['id' => $id]);

        $kriteria = Kriteria::findOrFail($id);
        $documents = Dokumen::where('kriteria_id', $id)->with('kriteria')->get();

        logger()->info('Dokumen ditemukan:', $documents->toArray());

        // Tambahkan variabel $nomor agar tersedia di view
        return view('kriteria.lihat', [
            'kriterias' => $kriteria,
            'tahap' => $kriteria->tahap,
            'documents' => $documents,
            'nomor' => $nomor,
        ]);
    }

    // Halaman unggah dokumen
    public function upload($id)
    {
        $kriteria = Kriteria::all();
        return view('kriteria.upload', compact('kriteria', 'id'));
    }

    // Halaman buat kriteria
    public function create(Request $request)
    {
        $tahap = $request->input('tahap');
        $nomor = $request->input('nomor');

        return view('kriteria.create', compact('tahap', 'nomor'));
    }

    // Simpan kriteria tanpa dokumen
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

    // Simpan kriteria dan dokumen sekaligus
    public function storeWithDokumen(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,png,zip|max:2048',
            'link' => 'nullable|string',
            'tahap' => 'required|string',
            'nomor' => 'required|integer',
            'status' => 'nullable|string',
        ]);

        try {
            $count = Kriteria::where('nomor', $request->nomor)
                             ->where('tahap', $request->tahap)
                             ->count();
            $newNomor = $request->nomor . '.' . ($count + 1);

            $kriteria = Kriteria::create([
                'nama' => $request->judul,
                'tahap' => $request->tahap,
                'nomor' => $newNomor,
            ]);

            $dokumen = new Dokumen();
            $dokumen->kriteria_id = $kriteria->id;
            $dokumen->judul = $request->judul;
            $dokumen->deskripsi = $request->deskripsi;
            $dokumen->status = $request->status ?? 'draft';
            $dokumen->link = $request->link;
            $dokumen->tahap = $request->tahap;
            $dokumen->user_id = auth()->id();

            if ($request->hasFile('file')) {
    $file = $request->file('file');
    $filename = uniqid() . '.' . $file->getClientOriginalExtension();
    $destinationPath = public_path('dokumen'); // simpan ke /public/dokumen
    $file->move($destinationPath, $filename);
    $dokumen->file_path = 'dokumen/' . $filename; // simpan path relatif
}



            $dokumen->save();

            return redirect()->route('kriteria.index', ['nomor' => $request->nomor])
                ->with('success', 'Dokumen dan kriteria berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan dokumen dengan kriteria: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    // Hapus kriteria
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

    // Halaman edit kriteria
    public function edit($id)
    {
        $kriteria = Kriteria::findOrFail($id);
        return view('kriteria.editkriteria', compact('kriteria'));
    }

    // Perbarui kriteria
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

    // Tampilkan halaman template untuk pengisian dokumen
    public function template($tahap = null, $nomor = null)
    {
        $kriterias = Kriteria::all();
        return view('kriteria.template', compact('kriterias', 'tahap', 'nomor'));
    }

    // Simpan dokumen dari template
    public function storeFromTemplate(Request $request)
    {
        $request->validate([
            'kriteria_id' => 'required|numeric|min:1|max:9',
            'tahap' => 'required|in:penetapan,pelaksanaan,evaluasi,pengendalian,peningkatan',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'isi' => 'nullable|string',
        ]);

        try {
            $count = Kriteria::where('nomor', $request->kriteria_id)
                             ->where('tahap', $request->tahap)
                             ->count();
            $newNomor = $request->kriteria_id . '.' . ($count + 1);

            $kriteria = Kriteria::create([
                'nama' => 'Kriteria ' . $newNomor,
                'nomor' => $newNomor,
                'tahap' => $request->tahap,
            ]);

            $dokumen = new Dokumen();
            $dokumen->kriteria_id = $kriteria->id;
            $dokumen->tahap = $request->tahap;
            $dokumen->judul = $request->judul;
            $dokumen->deskripsi = $request->deskripsi;
            $dokumen->isi = $request->isi;
            $dokumen->status = $request->status ?? null;
            $dokumen->user_id = auth()->id();
            $dokumen->save();

            return redirect()->route('dokumen.template')->with('success', 'Dokumen berhasil disimpan.');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan dokumen dari template: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }
}
