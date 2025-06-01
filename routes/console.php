<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// JADWALKAN COMMAND SITEMAP ANDA DI SINI:
Schedule::command('sitemap:generate')->daily();
// Anda bisa menggunakan frekuensi lain:
// ->hourly();
// ->twiceDaily(1, 13); // Jam 1 pagi dan 1 siang
// ->everyMinute(); // Untuk testing, jangan gunakan di produksi untuk sitemap
