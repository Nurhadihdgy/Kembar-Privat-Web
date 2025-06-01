<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['nama', 'slug'];

    // Relasi many-to-many dengan Artikel
    public function artikels()
    {
        return $this->belongsToMany(Artikel::class, 'artikel_tag', 'tag_id', 'artikel_id');
    }
}
