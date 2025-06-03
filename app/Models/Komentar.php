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
        'komentar',   // Isi komentar (jika ada, bisa dihapus jika tidak pakai)
        'table',      // Nama tabel yang dikomentari (optional, bisa dihapus jika tidak pakai)
        'isi',        // Isi komentar utama
        'page',       // Halaman atau nomor kriteria (optional)
    ];

    // Relasi ke dokumen
    public function dokumen()
    {
        return $this->belongsTo(Dokumen::class);
    }

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
