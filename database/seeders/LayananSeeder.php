<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Layanan;

class LayananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Layanan::insert([
        [
            'nama' => 'Belajar Membaca Al-Qur\'an',
            'gambar' => 'layanan/belajar-baca.jpg',
            'deskripsi' => 'Program dasar untuk anak-anak & dewasa yang belum lancar membaca Al-Qur’an.',
            'harga' => 'Rp200.000 / bulan',
            'label' => 'Populer',
        ],
        [
            'nama' => 'Tahfidz Al-Qur\'an',
            'gambar' => 'layanan/tahfidz.jpg',
            'deskripsi' => 'Bimbingan menghafal Al-Qur’an dengan metode muroja’ah dan talaqqi.',
            'harga' => 'Rp250.000 / bulan',
            'label' => 'Rekomendasi',
        ]
    ]);
    }
}
