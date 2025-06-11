<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    use HasFactory;

    protected $table = 'kriteria';

    // Tambahkan 'tahap' dan 'nomor' ke fillable
    protected $fillable = ['nama', 'tahap', 'nomor'];

    public function dokumen()
    {
        return $this->hasMany(Dokumen::class);
    }
}

