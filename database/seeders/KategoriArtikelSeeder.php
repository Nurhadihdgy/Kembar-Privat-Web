<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\KategoriArtikel; // Pastikan Anda membuat model ini
use Illuminate\Support\Str;

class KategoriArtikelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoriArtikels = [
            'Tips Belajar Al-Qur\'an',
            'Metode Menghafal',
            'Keutamaan Al-Qur\'an',
            'Parenting Islami',
            'Pendidikan Anak',
            'Kisah Inspiratif Islami',
            'Fiqih Ibadah Harian',
            'Adab & Akhlak Muslim',
            'Info Kembar Privat', // Untuk berita atau pengumuman lembaga
            'Tajwid Praktis',
            'Tafsir Ringkas',
        ];

        foreach ($kategoriArtikels as $namaKategori) {
            KategoriArtikel::firstOrCreate(
                ['slug' => Str::slug($namaKategori)], // Cek berdasarkan slug untuk menghindari duplikat jika nama diubah sedikit
                ['nama' => $namaKategori]
            );
        }

        // Contoh jika Anda ingin memastikan slug selalu unik berdasarkan nama saat pembuatan awal
        /*
        foreach ($kategoriArtikels as $namaKategori) {
            if (!KategoriArtikel::where('nama', $namaKategori)->exists()) {
                KategoriArtikel::create([
                    'nama' => $namaKategori,
                    'slug' => Str::slug($namaKategori),
                ]);
            }
        }
        */
    }
}
