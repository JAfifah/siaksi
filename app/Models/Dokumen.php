<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokumen extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'deskripsi',
        'file_path',
        'user_id',
        'kriteria_id'
    ];

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class);
    }
    
    public function komentars()
    {
        return $this->hasMany(Komentar::class);
    }

    public function validasi($id)
{
    $dokumen = Dokumen::with('kriteria')->find($id); // <--- ini penting!

    return view('kriteria.validasi', compact('dokumen'));
}


    protected $table = 'dokumen';
}
