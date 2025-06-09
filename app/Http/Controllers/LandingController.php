<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slider; // <-- Tambahkan ini
use App\Models\TentangKami;
use App\Models\Artikel;
use App\Models\Tag;
use App\Models\Anggota;
use App\Models\Galeri;
use App\Models\ContactInfo;
use App\Models\Ulasan;
use App\Models\Layanan;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Support\Str;

class LandingController extends Controller
{
    public function index()
    {
        $sliders = Slider::latest()->get();
        $tentangKami = TentangKami::first();
        $layanans = \App\Models\Layanan::where('is_active', true)->latest()->take(3)->get(); // ambil 3 layanan terbaru
        $artikels = Artikel::where('is_published', true)->latest()
            ->take(6) // misal ambil 6 artikel terbaru
            ->get();
        $anggota = Anggota::where('is_active', true)->paginate(10);
        $galeris = Galeri::latest()->take(3)->get();
        $contact = ContactInfo::first();

        SEOMeta::setTitle('Beranda | Kembar Privat Al-Quran');
        SEOMeta::setDescription('Les privat mengaji di rumah dengan guru berpengalaman. Belajar Al-Quran jadi lebih mudah dan nyaman.');
        SEOMeta::setCanonical(route('home'));

        $ulasans = Ulasan::where('is_tampil', true)
            ->with('layanan') // <-- Eager load relasi layanan
            ->latest()
            ->take(9)
            ->get();

        // Hitung rating rata-rata untuk SEO
        $totalUlasan = Ulasan::where('is_tampil', true)->count();
        $averageRating = Ulasan::where('is_tampil', true)->avg('rating');

        return view('landing.index', compact('sliders', 'tentangKami', 'layanans', 'artikels', 'anggota', 'galeris', 'contact', 'ulasans', 'totalUlasan', 'averageRating'));
    }

    public function tentangKami()
    {
        $tentangKami = \App\Models\TentangKami::firstOrFail();
        SEOMeta::setTitle('Tentang Kami | Kembar Privat Al-Quran');
        SEOMeta::setDescription(Str::limit(strip_tags($tentangKami->isi), 160));
        SEOMeta::setCanonical(route('tentang-kami'));
        return view('landing.tentang-kami', compact('tentangKami'));
    }
    public function layanan()
    {
        $layanans = \App\Models\Layanan::where('is_active', true)->latest()->get();

        return view('landing.layanan-index', compact('layanans'));
    }

    public function layananShow($slug)
    {
        $layanan = \App\Models\Layanan::where('slug', $slug)->firstOrFail();
        SEOMeta::setTitle($layanan->judul . ' | Layanan Kembar Privat');
        SEOMeta::setDescription(Str::limit(strip_tags($layanan->deskripsi), 150));
        SEOMeta::setCanonical(route('layanan.show', $layanan->slug));

        return view('landing.layanan-show', compact('layanan'));
    }

    public function artikelIndex()
    {
        $artikels = Artikel::where('is_published', true)->orderByDesc('published_at')->get();
        return view('landing.artikel.index', compact('artikels'));
    }

    public function artikelShow($slug)
    {
        $artikel = Artikel::where('slug', $slug)->with('tags')->firstOrFail();

        dd($artikel->toArray());

        SEOMeta::setTitle($artikel->judul);
        SEOMeta::setDescription(Str::limit(strip_tags($artikel->isi), 150));
        SEOMeta::setCanonical(route('artikel.show', $artikel->slug));

        return view('landing.artikel.show', compact('artikel'));
    }
    public function Tagshow($slug)
    {
        // Cari tag berdasarkan slug
        $tag = Tag::where('slug', $slug)->firstOrFail();

        // Ambil artikel yang punya tag ini, urut terbaru dan paginasi 10
        $artikels = $tag->artikels()->latest('published_at')->paginate(10);
        SEOMeta::setTitle('Artikel dengan tag: ' . $tag->nama);
        SEOMeta::setDescription('Kumpulan artikel dengan topik "' . $tag->nama . '" dari Kembar Privat Al-Quran.');
        SEOMeta::setCanonical(route('tag.show', $tag->slug));

        return view('landing.tags.show', compact('tag', 'artikels'));
    }

    public function store(Request $request, Artikel $artikel)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'isi' => 'required|string',
            'parent_id' => 'nullable|exists:komentars,id',
        ]);

        $artikel->komentars()->create([
            'nama' => $request->nama,
            'isi' => $request->isi,
            'parent_id' => $request->parent_id,
            'is_active' => true, // atau false jika perlu moderasi
        ]);

        return redirect()->back()->with('success', 'Komentar berhasil ditambahkan.');
    }

    public function anggotaindex()
    {
        $anggota = Anggota::where('is_active', true)->paginate(10);

        return view('landing.anggota.index', compact('anggota'));
    }
    public function anggotashow($id)
    {
        $anggota = Anggota::findOrFail($id);

        return view('landing.anggota.show', compact('anggota'));
    }

    public function galeriindex()
    {
        $galeris = Galeri::latest()->get();
        return view('landing.galeri.index', compact('galeris'));
    }
    // public function contactinfoindex()
    //     {
    //         $contact = ContactInfo::first();
    //         return view('kontak', compact('contact'));
    //     }
    public function ulasanIndex()
    {
        // Ambil data untuk ringkasan rating
        $totalUlasan = Ulasan::where('is_tampil', true)->count();
        $averageRating = Ulasan::where('is_tampil', true)->avg('rating');
        $ratingCounts = Ulasan::where('is_tampil', true)
            ->selectRaw('rating, count(*) as count')
            ->groupBy('rating')
            ->pluck('count', 'rating');

        // Ambil semua ulasan dengan paginasi
        $ulasans = Ulasan::where('is_tampil', true)
            ->with('layanan')
            ->latest()
            ->paginate(12); // Tampilkan 12 ulasan per halaman

            
        return view('landing.ulasan.index', compact('ulasans', 'totalUlasan', 'averageRating', 'ratingCounts'));
    }

    public function tulisUlasan()
    {
        $layanans = Layanan::where('is_active', true)->pluck('nama', 'id');
        return view('landing.ulasan.create', compact('layanans'));
    }

    public function storeUlasan(Request $request)
    {
        $validated = $request->validate([
            'nama_pengulas' => 'required|string|max:255',
            'layanan_id' => 'nullable|exists:layanans,id',
            'rating' => 'required|integer|min:1|max:5',
            'ulasan' => 'required|string|max:5000',
        ]);

        // Set is_tampil ke false, akan dimoderasi oleh admin
        $validated['is_tampil'] = true;

        Ulasan::create($validated);

        return redirect()->route('ulasan.index')->with('success', 'Terima kasih! Ulasan Anda telah terkirim dan akan kami tinjau.');
    }
}
