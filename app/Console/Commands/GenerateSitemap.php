<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
    use Spatie\Sitemap\Tags\Url;
    use App\Models\Artikel;
    use App\Models\Layanan;
    use App\Models\Anggota;
    use App\Models\KategoriArtikel;
    use Illuminate\Support\Facades\Route;
    use App\Models\Tag;

class GenerateSitemap extends Command
    {
        /**
         * The name and signature of the console command.
         *
         * @var string
         */
        protected $signature = 'sitemap:generate';

        /**
         * The console command description.
         *
         * @var string
         */
        protected $description = 'Generate the sitemap.xml file for the website';

        /**
         * Execute the console command.
         */
        public function handle()
        {
            $this->info('Generating sitemap...');

            $sitemap = Sitemap::create();

            // 1. Tambahkan URL Halaman Statis
            $sitemap->add(Url::create(route('home'))->setPriority(1.0)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY));
            $sitemap->add(Url::create(route('tentang-kami'))->setPriority(0.8)->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY));
            $sitemap->add(Url::create(route('layanan.index'))->setPriority(0.8)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY));
            $sitemap->add(Url::create(route('artikel.index'))->setPriority(0.8)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY));
            $sitemap->add(Url::create(route('galeri.index'))->setPriority(0.7)->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY));

            // 2. Tambahkan URL dari Model Artikel
            Artikel::where('is_published', true)->orderBy('updated_at', 'desc')->get()->each(function (Artikel $artikel) use ($sitemap) {
                $sitemap->add(
                    Url::create(route('artikel.show', $artikel->slug))
                        ->setLastModificationDate($artikel->updated_at)
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                        ->setPriority(0.9)
                );
            });

            // 3. Tambahkan URL dari Model Layanan
            Layanan::where('is_active', true)->get()->each(function (Layanan $layanan) use ($sitemap) {
                $sitemap->add(
                    Url::create(route('layanan.show', $layanan->slug))
                        ->setLastModificationDate($layanan->updated_at ?? now())
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                        ->setPriority(0.8)
                );
            });

            // 4. Tambahkan URL dari Model Anggota
            Anggota::where('is_active', true)->get()->each(function (Anggota $anggota) use ($sitemap) {
                $sitemap->add(
                    Url::create(route('anggota.show', $anggota->id))
                        ->setLastModificationDate($anggota->updated_at ?? now())
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                        ->setPriority(0.7)
                );
            });

            
            // 6. Tambahkan URL dari Model Tag
            Tag::all()->each(function (Tag $tag) use ($sitemap) {
                 if (Route::has('tag.show')) {
                    $sitemap->add(
                        Url::create(route('tag.show', $tag->slug)) 
                            ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                            ->setPriority(0.5)
                    );
                }
            });

            // Simpan sitemap ke file public/sitemap.xml
            $sitemap->writeToFile(public_path('sitemap.xml'));

            $this->info('Sitemap generated successfully and saved to public/sitemap.xml');
            return Command::SUCCESS;
        }
    }
