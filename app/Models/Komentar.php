<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Komentar extends Model
{
    use HasFactory;
<<<<<<< HEAD

    protected $fillable = [
        'dokumen_id', // ID dokumen yang dikomentari
        'user_id',    // ID pengguna yang memberikan komentar
        'komentar',   // Isi komentar
    ];

    // Relasi ke tabel dokumen (jika diperlukan)
    public function dokumen()
    {
        return $this->belongsTo(Dokumen::class);
    }

    // Relasi ke tabel user
=======
    protected $fillable = ['user_id', 'table', 'isi'];

>>>>>>> 2e8eb87c39bff4f296f17a31cb9684ef9f627139
    public function user()
    {
        return $this->belongsTo(User::class);
    }
<<<<<<< HEAD
}
=======
}
>>>>>>> 2e8eb87c39bff4f296f17a31cb9684ef9f627139
