<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    /** @use HasFactory<\Database\Factories\AnggotaFactory> */
    use HasFactory;

    protected $table = 'anggota';

    protected $fillable = [
    'nama',
    'jenis_kelamin',
    'telepon',
    'profil',
    'foto', // <-- PASTIKAN INI ADA
    'tipe',
    'is_active',
];
}
