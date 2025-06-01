<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriArtikel extends Model
{
    // KategoriArtikel.php
    protected $fillable = ['nama', 'slug'];
    public function artikels()
    {
        return $this->hasMany(Artikel::class);
    }
}
