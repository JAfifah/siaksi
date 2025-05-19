<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Komentar extends Model
{
    use HasFactory;

    protected $fillable = [
        'dokumen_id', // ID dokumen yang dikomentari
        'user_id',    // ID pengguna yang memberikan komentar
        'komentar',   // Isi komentar
        'table',      // Nama tabel yang dikomentari (dari versi lain)
        'isi',        // Isi komentar (alternatif atau tambahan)
        'page',       // Halaman atau nomor kriteria
    ];

    // Relasi ke tabel dokumen (jika diperlukan)
    public function dokumen()
    {
        return $this->belongsTo(Dokumen::class);
    }

    // Relasi ke tabel user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}