<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ContactInfo;

class ContactInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        ContactInfo::updateOrCreate(
            ['id' => 1],
            [
                'alamat' => 'Jl. Contoh No.123, Jakarta',
                'telepon' => '021-12345678',
                'whatsapp' => '6281234567890',
                'instagram' => 'contoh_ig',
            ]
        );
    }
}
