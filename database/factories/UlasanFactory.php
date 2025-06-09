<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Layanan;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ulasan>
 */
class UlasanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Ambil ID layanan yang ada secara acak. Pastikan tabel 'layanans' sudah ada isinya.
        $layananIds = Layanan::pluck('id')->toArray();

        // Kumpulan nama-nama Islami/Indonesia untuk pengulas
        $namaIslami = [
            'Abdullah Al-Fatih', 'Aisyah Humaira', 'Muhammad Alif', 'Fatimah Az-Zahra', 'Yusuf Al-Banjari',
            'Khadijah Al-Kubra', 'Umar Setiawan', 'Zainab Putri', 'Ali Firmansyah', 'Hasanuddin',
            'Amirul Huda', 'Siti Nurjanah', 'Rizki Ramadhan', 'Nurul Hidayah', 'Imam Subagja',
            'Hafsah Wulandari', 'Salman Hakim', 'Dewi Lestari', 'Agus Santoso', 'Putri Ananda',
            'Budi Hartono', 'Annisa Fitriani', 'Eko Prasetyo', 'Nur Aini', 'Joko Susilo',
            'Sri Wahyuni', 'Ahmad Zulkarnain', 'Cut Mutia', 'Teuku Rizky', 'R.A. Anjani'
        ];

        // Kumpulan ulasan positif yang relevan
        $ulasanPositif = [
            'Pengajarnya sangat sabar dan metode mengajarnya mudah diikuti. Anak saya jadi lebih semangat mengaji. Terima kasih Kembar Privat!',
            'Alhamdulillah, bacaan saya jauh lebih baik setelah ikut program tahsin di sini. Penjelasan tajwidnya detail dan mudah dipahami.',
            'Jadwalnya fleksibel, sangat membantu saya yang bekerja. Bisa tetap belajar Al-Quran di sela-sela kesibukan. Recommended!',
            'Anak saya yang tadinya pemalu sekarang jadi lebih percaya diri saat membaca Al-Quran. Guru privatnya sangat bisa membangun kedekatan.',
            'Materi yang diberikan terstruktur dengan baik, dari nol sampai bisa membaca lancar. Sangat cocok untuk dewasa yang baru mau mulai belajar.',
            'Adminnya responsif dan sangat membantu dalam mengatur jadwal. Pelayanan yang profesional dan memuaskan.',
            'Program tahfidznya luar biasa. Guru pembimbingnya tidak hanya menyimak hafalan, tapi juga memberikan motivasi. Jazakumullah khairan.',
            'Anak-anak suka sekali dengan metode belajarnya yang diselingi permainan. Belajar mengaji jadi tidak membosankan. Maju terus Kembar Privat!',
            'Sebagai orang tua, saya merasa tenang karena progres belajar anak terpantau dengan baik. Ada laporan berkala yang sangat membantu.',
            'Akhirnya menemukan tempat les privat yang benar-benar fokus pada kualitas bacaan. Setiap pertemuan sangat berarti. Barokallah.',
        ];

        return [
            'nama_pengulas' => $this->faker->randomElement($namaIslami),
            'layanan_id' => $this->faker->optional(0.8)->randomElement($layananIds),
            'rating' => $this->faker->numberBetween(4, 5),
            'ulasan' => $this->faker->randomElement($ulasanPositif), // <-- DIUBAH: Memilih ulasan dari array
            'is_tampil' => true,
            'created_at' => $this->faker->dateTimeBetween('-3 months', 'now'),
            'updated_at' => now(),
        ];
    }
}
