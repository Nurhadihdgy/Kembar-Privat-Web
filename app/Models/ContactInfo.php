<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactInfo extends Model
{
    protected $fillable = [
        'alamat',
        'telepon',
        'whatsapp',
        'instagram',
        'google_maps_url',
    ];
}
