<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Layanan extends Model
{
    /** @use HasFactory<\Database\Factories\LayananFactory> */
    use HasFactory;

    protected $fillable = ['nama', 'slug', 'gambar', 'deskripsi', 'harga', 'label','is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function booted()
    {
        static::creating(function ($layanan) {
            $layanan->slug = Str::slug($layanan->nama);
        });

        static::updating(function ($layanan) {
            $layanan->slug = Str::slug($layanan->nama);
        });
    }
}
