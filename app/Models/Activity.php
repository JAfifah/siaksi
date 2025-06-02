<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Activity extends Model
{
    protected $fillable = [
        'user_id',
        'dokumen_id',
        'komentar_id',  // tambahkan jika pakai komentar_id di activities
        'type',
        'description',
        'action',
        'is_read',
    ];

    // Relasi ke user
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke dokumen
    public function dokumen(): BelongsTo
    {
        return $this->belongsTo(Dokumen::class, 'dokumen_id');
    }

    // Relasi ke komentar
    public function komentar(): BelongsTo
    {
        return $this->belongsTo(Komentar::class, 'komentar_id');
    }
}
