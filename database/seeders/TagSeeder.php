<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tag;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            'Belajar Al-Qur\'an',
            'Tahfidz Al-Qur\'an',
            'Tajwid',
            'Metode Menghafal Cepat',
            'Privat Mengaji',
            'Guru Ngaji Online',
            'Mengaji untuk Anak',
            'Mengaji untuk Dewasa',
            'Tilawah',
            'Tartil',
            'Bimbingan Iqro',
            'Hafalan Juz Amma',
            'Murottal Anak',
            'Kajian Islam',
            'Doa Sehari-hari',
            'Adab Islami',
            'Hadits Pilihan',
            'Motivasi Islami',
            'Kelas Islami Anak',
            'Pembelajaran Akhlak',
            'Kursus Ngaji Privat',
            'Ngaji Online Bersertifikat',
            'Ngaji dari Nol',
            'Program Al-Qur\'an Intensif',
            'Islamic Parenting',
        ];

        foreach ($tags as $tag) {
            Tag::firstOrCreate([
                'nama' => $tag,
            ], [
                'slug' => Str::slug($tag),
            ]);
        }
    }
}
