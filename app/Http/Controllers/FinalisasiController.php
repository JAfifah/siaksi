<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kriteria;
use App\Models\Dokumen;
use Illuminate\Support\Facades\Auth;

class FinalisasiController extends Controller
{
    // Menampilkan daftar finalisasi
    public function index()
    {
        if (!in_array(Auth::user()->role, ['administrator', 'direktur'])) {
            abort(403, 'Hanya administrator dan direktur yang dapat mengakses halaman ini.');
        }

        // Ambil semua kriteria yang sudah dikirim finalisasi
        $kriterias = Kriteria::where('finalisasi_dikirim', true)
            ->orderBy('nomor')
            ->get()
            ->groupBy('nomor');

        // GANTI NAMA VIEW sesuai file yang kamu punya (finalisasi.blade.php)
        return view('finalisasi', [
            'kriterias' => $kriterias
        ]);
    }

    // Admin mengirim finalisasi ke direktur
    public function kirim($nomor)
    {
        if (!in_array(Auth::user()->role, ['administrator'])) {
            abort(403, 'Anda tidak memiliki akses untuk mengirim finalisasi.');
        }

        $kriterias = Kriteria::where('nomor', $nomor)->get();

        $semuaValid = true;
        foreach ($kriterias as $kriteria) {
            $dokumen = Dokumen::where('kriteria_id', $kriteria->id)->first();

            if (!$dokumen || $dokumen->status !== 'disetujui') {
                $semuaValid = false;
                break;
            }
        }

        if (!$semuaValid) {
            return redirect()->back()->with('error', 'Finalisasi gagal. Semua dokumen kriteria harus sudah disetujui.');
        }

        foreach ($kriterias as $kriteria) {
            $kriteria->finalisasi_dikirim = true;
            $kriteria->save();
        }

        return redirect()->back()->with('success', 'Dokumen finalisasi berhasil dikirim ke Direktur.');
    }

    // Direktur dan Administrator melihat isi finalisasi
    public function show($nomor)
    {
        if (!in_array(Auth::user()->role, ['administrator', 'direktur'])) {
            abort(403, 'Anda tidak memiliki akses untuk melihat halaman ini.');
        }

        $kriterias = Kriteria::where('nomor', $nomor)
            ->where('finalisasi_dikirim', true)
            ->get();

        return view('finalisasi.show', [
            'kriterias' => $kriterias,
            'nomor' => $nomor
        ]);
    }

    // Hanya Direktur dan Administrator yang bisa memfinalisasi
    public function validasi(Request $request, $nomor)
    {
        if (!in_array(Auth::user()->role, ['administrator', 'direktur'])) {
            abort(403, 'Hanya administrator dan direktur yang dapat memfinalisasi.');
        }

        $kriterias = Kriteria::where('nomor', $nomor)
            ->where('finalisasi_dikirim', true)
            ->get();

        foreach ($kriterias as $kriteria) {
            $kriteria->finalisasi_disetujui = true;
            $kriteria->save();
        }

        return redirect()->route('dashboard')->with('success', 'Finalisasi berhasil disetujui.');
    }

    // Direktur atau administrator menyetujui satu grup kriteria (alias method 'setujui')
    public function setujui($id)
    {
        if (!in_array(Auth::user()->role, ['administrator', 'direktur'])) {
            abort(403, 'Anda tidak memiliki izin untuk menyetujui finalisasi.');
        }

        $kriteria = Kriteria::findOrFail($id);
        $nomor = $kriteria->nomor;

        $kriterias = Kriteria::where('nomor', $nomor)->get();

        foreach ($kriterias as $item) {
            $item->finalisasi_disetujui = true;
            $item->save();
        }

        return redirect()->back()->with('success', 'Kriteria berhasil disetujui.');
    }

    // Mengembalikan finalisasi ke tahap revisi
    public function kembalikan($id)
    {
        if (!in_array(Auth::user()->role, ['administrator', 'direktur'])) {
            abort(403, 'Anda tidak memiliki izin untuk mengembalikan kriteria.');
        }

        $kriteria = Kriteria::findOrFail($id);

        // Ambil semua kriteria yang memiliki nomor sama
        $kriteriaGroup = Kriteria::where('nomor', $kriteria->nomor)->get();

        foreach ($kriteriaGroup as $item) {
            $item->finalisasi_disetujui = false;
            $item->finalisasi_dikirim = false; // opsional, jika ingin dikirim ulang
            $item->save();
        }

        return redirect()->back()->with('success', 'Kriteria berhasil dikembalikan untuk revisi.');
    }
}
