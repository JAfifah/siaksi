<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kriteria;

class KriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kriteria = [
            [
                'nama' => 'Statuta Polinema',
                'tahap' => 'penetapan',
                'nomor' => 1
            ],
            [
                'nama' => 'Surat Tugas Tim Penyusun VMTS',
                'tahap' => 'penetapan',
                'nomor' => 1
            ],
            [
                'nama' => 'SK penetapan VMTS D4 SIB',
                'tahap' => 'penetapan',
                'nomor' => 1
            ],
            [
                'nama' => 'Renstra Polinema 2020-2024',
                'tahap' => 'penetapan',
                'nomor' => 1
            ],
            [
                'nama' => 'Dokumen Strategi Pencapaian VMTS',
                'tahap' => 'penetapan',
                'nomor' => 1
            ],
            [
                'nama' => 'Dokumen Visi Keilmuan',
                'tahap' => 'penetapan',
                'nomor' => 1
            ],
            [
                'nama' => 'Link Sosialisasi VMTS via website',
                'tahap' => 'pelaksanaan',
                'nomor' => 1
            ],
            [
                'nama' => 'Salah satu Bukti pelaksanaan misi melaksanakan pendidikan yang siap bersaing di level global',
                'tahap' => 'pelaksanaan',
                'nomor' => 1
            ],
            [
                'nama' => 'Salah satu Bukti pelaksanaan misi melaksanakan Penelitian yang diadopsi masyarakat',
                'tahap' => 'pelaksanaan',
                'nomor' => 1
            ],
            [
                'nama' => 'Salah satu Bukti pelaksanaan misi melaksanakan PKM yang diadopsi masyarakat',
                'tahap' => 'pelaksanaan',
                'nomor' => 1
            ],
            [
                'nama' => 'Salah satu Bukti pelaksanaan misi melaksanakan Tata Kelola yang baik',
                'tahap' => 'pelaksanaan',
                'nomor' => 1
            ],
            [
                'nama' => 'Salah satu Bukti pelaksanaan misi melaksanakan Kerjasama di dalam dan luar negeri',
                'tahap' => 'pelaksanaan',
                'nomor' => 1
            ],
            [
                'nama' => 'Laporan AMI',
                'tahap' => 'evaluasi',
                'nomor' => 1
            ],
            [
                'nama' => 'Form Survei Pemahaman dan keterlaksanaan VMTS',
                'tahap' => 'evaluasi',
                'nomor' => 1
            ],
            [
                'nama' => 'Dokumen Notulensi RTM',
                'tahap' => 'pengendalian',
                'nomor' => 1
            ],
            [
                'nama' => 'Dokumen Laporan Kinerja',
                'tahap' => 'pengendalian',
                'nomor' => 1
            ],
            [
                'nama' => 'Dokumen Rencana Kerja',
                'tahap' => 'peningkatan',
                'nomor' => 1
            ],
            [
                'nama' => 'Sistem Penjaminan Mutu Internal (SPMI)',
                'tahap' => 'penetapan',
                'nomor' => 2
            ],
        ];

        foreach ($kriteria as $k) {
            Kriteria::create($k);
        }
    }
}