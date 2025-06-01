<?php

use App\Http\Controllers\LandingController;
use Illuminate\Support\Facades\Route;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Artikel;
use App\Models\Layanan;
use App\Models\Anggota;
use App\Models\Tag;
use Illuminate\Http\Request;

// Route::get('/sitemap.xml', function (Request $request) {
//     $sitemap = Sitemap::create();

//     // 1. Tambahkan URL Halaman Statis
//     // Pastikan semua nama route yang digunakan di sini sudah didefinisikan di bawah
//     $sitemap->add(Url::create(route('home'))->setPriority(1.0)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY));
//     $sitemap->add(Url::create(route('tentang-kami'))->setPriority(0.8)->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY));
//     $sitemap->add(Url::create(route('layanan.index'))->setPriority(0.8)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY));
//     $sitemap->add(Url::create(route('artikel.index'))->setPriority(0.8)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY));
//     $sitemap->add(Url::create(route('galeri.index'))->setPriority(0.7)->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY));
//     // Tambahkan route statis lainnya jika ada

//     // 2. Tambahkan URL dari Model Artikel
//     Artikel::where('is_published', true)->orderBy('updated_at', 'desc')->get()->each(function (Artikel $artikel) use ($sitemap) {
//         $sitemap->add(
//             Url::create(route('artikel.show', $artikel->slug))
//                 ->setLastModificationDate($artikel->updated_at)
//                 ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
//                 ->setPriority(0.9)
//         );
//     });

//     // 3. Tambahkan URL dari Model Layanan
//     Layanan::where('is_active', true)->get()->each(function (Layanan $layanan) use ($sitemap) {
//         $sitemap->add(
//             Url::create(route('layanan.show', $layanan->slug))
//                 ->setLastModificationDate($layanan->updated_at ?? now())
//                 ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
//                 ->setPriority(0.8)
//         );
//     });

//     // 4. Tambahkan URL dari Model Anggota (jika halaman detail anggota publik)
//     Anggota::where('is_active', true)->get()->each(function (Anggota $anggota) use ($sitemap) {
//         $sitemap->add(
//             Url::create(route('anggota.show', $anggota->id))
//                 ->setLastModificationDate($anggota->updated_at ?? now())
//                 ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
//                 ->setPriority(0.7)
//         );
//     });

    
//     // 6. Tambahkan URL dari Model Tag
//     Tag::all()->each(function (Tag $tag) use ($sitemap) {
//          if (Route::has('tag.show')) { // PERBAIKAN TYPO: Route.has menjadi Route::has
//             $sitemap->add(
//                 Url::create(route('tag.show', $tag->slug)) 
//                     ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
//                     ->setPriority(0.5)
//             );
//         }
//     });

//     return $sitemap->toResponse($request);
// });

// Definisi Route Aplikasi Anda
// Pastikan nama method di LandingController sesuai dengan yang didefinisikan di sini.
Route::get('/', [LandingController::class, 'index'])->name('home');
Route::get('/tentang-kami', [LandingController::class, 'tentangKami'])->name('tentang-kami');

Route::get('/layanan', [LandingController::class, 'layanan'])->name('layanan.index'); // Konvensi: layananIndex
Route::get('/layanan/{slug}', [LandingController::class, 'layananShow'])->name('layanan.show');

Route::get('/artikel', [LandingController::class, 'artikelIndex'])->name('artikel.index');
Route::get('/artikel/{slug}', [LandingController::class, 'artikelShow'])->name('artikel.show');

Route::get('/tag/{slug}', [LandingController::class, 'Tagshow'])->name('tag.show'); // Konvensi: tagShow

Route::post('/artikel/{artikel}/komentar', [LandingController::class, 'storeKomentar'])->name('komentar.store');

Route::get('/anggota', [LandingController::class, 'anggotaindex'])->name('anggota.index');
Route::get('/anggota/{id}', [LandingController::class, 'anggotashow'])->name('anggota.show');

Route::get('/galeri', [LandingController::class, 'galeriindex'])->name('galeri.index');

