<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Ulasan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_pengulas',
        'layanan_id',
        'rating',
        'ulasan',
        'is_tampil',
    ];

    protected $casts = [
        'is_tampil' => 'boolean',
        'rating' => 'integer',
    ];

    /**
     * Mendapatkan layanan yang diulas.
     */
    public function layanan(): BelongsTo
    {
        return $this->belongsTo(Layanan::class);
    }
}
