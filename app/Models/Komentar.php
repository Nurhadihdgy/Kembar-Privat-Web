<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Komentar extends Model
{
    protected $fillable = [
    'artikel_id',
    'nama',
    'isi',
    'parent_id',
    'is_active',
];

public function artikel()
{
    return $this->belongsTo(Artikel::class);
}
public function replies()
{
    return $this->hasMany(Komentar::class, 'parent_id')->where('is_active', true)->latest();
}

public function parent()
{
    return $this->belongsTo(Komentar::class, 'parent_id');
}

public function scopeAktif($query)
{
    return $query->where('is_active', true);
}

}
