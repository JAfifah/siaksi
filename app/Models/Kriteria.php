<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    use HasFactory;
    protected $table = 'kriteria'; // <- ini penting
    protected $fillable = ['nama'];
    public function dokumen()
{
    return $this->hasOne(Dokumen::class);
}

}
