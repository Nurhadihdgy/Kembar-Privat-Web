<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Artikel extends Model
{
    protected $fillable = [
        'judul',
        'slug',
        'kategori_artikel_id',
        'isi',
        'gambar',
        'published_at',
        'is_published', // <-- TAMBAHKAN INI
    ];
    protected $casts = [
        'published_at' => 'datetime',
        'is_published' => 'boolean', // <-- TAMBAHKAN INI
        'tags' => 'array', // Jika Anda menyimpan tags sebagai JSON, contoh saja
    ];

    protected static function booted()
    {
        static::creating(function ($artikel) {
            $artikel->slug = Str::slug($artikel->judul);
        });

        static::updating(function ($artikel) {
            $artikel->slug = Str::slug($artikel->judul);
        });
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriArtikel::class, 'kategori_artikel_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'artikel_tag', 'artikel_id', 'tag_id');
    }

    public function penulis()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function komentars()
{
    return $this->hasMany(Komentar::class)->whereNull('parent_id')->with('replies');
}
// Scope untuk artikel yang sudah dipublikasikan dan tanggal publikasinya tidak di masa depan
    public function scopePublished($query)
    {
        return $query->where('is_published', true)
                     ->whereNotNull('published_at')
                     ->where('published_at', '<=', now());
    }
}
