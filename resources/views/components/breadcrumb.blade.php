@php
    use Illuminate\Support\Facades\Request;
    use Illuminate\Support\Str;

    $segments = Request::segments();
    $url = url('/'); // Variabel untuk membangun URL link di dalam loop
    
    // Mapping untuk segment ke nama yang rapi
    $routeNames = [
        'tentang-kami' => 'Tentang Kami',
        'program-kami' => 'Program Kami',
        'kontak' => 'Kontak',
        'galeri' => 'Galeri',
        'artikel' => 'Artikel',
        'blog' => 'Blog', // Jika Anda juga menggunakan 'blog'
        'kategori' => 'Kategori',
        // 'detail' => 'Detail', // Biasanya tidak diperlukan sebagai nama breadcrumb jika diganti judul
    ];

    // Variabel untuk menyimpan judul spesifik untuk segmen terakhir (misalnya judul artikel)
    $titleForLastSegment = null;

    // Prioritaskan penggunaan variabel $artikel jika di-pass dari controller ke view
    if (isset($artikel) && $artikel instanceof \App\Models\Artikel && end($segments) === $artikel->slug) {
        $titleForLastSegment = $artikel->judul;
    }
    // Fallback jika $artikel tidak ada, coba query berdasarkan struktur URL umum /artikel/{slug}
    // Ini akan berfungsi untuk URL seperti /artikel/nama-slug-artikel
    else if (count($segments) >= 1 && $segments[0] === 'artikel' && count($segments) === 2) {
        $slug = $segments[1];
        $articleModel = \App\Models\Artikel::where('slug', $slug)->first();
        if ($articleModel) {
            $titleForLastSegment = $articleModel->judul;
        }
    }
    // Anda bisa menambahkan logika lain di sini untuk struktur URL yang berbeda jika diperlukan
    // Misalnya, untuk /artikel/kategori/{slug_kategori}
    else if (count($segments) >= 2 && $segments[0] === 'artikel' && $segments[1] === 'kategori' && isset($segments[2])) {
        $categorySlug = $segments[2];
        $categoryModel = \App\Models\KategoriArtikel::where('slug', $categorySlug)->first(); // Asumsi model KategoriArtikel
        if ($categoryModel) {
            $titleForLastSegment = $categoryModel->nama; // Ini akan menjadi nama kategori
        }
    }
@endphp

{{-- 
  Warna dasar untuk breadcrumbs: text-gray-600 (light mode), dark:text-gray-300 (dark mode)
  Warna link aktif: text-blue-800 (light mode), dark:text-blue-400 (dark mode)
--}}
<nav class="text-sm text-gray-600 dark:text-gray-300 mb-4 px-4 max-w-7xl mx-auto">
    <a href="{{ url('/') }}" class="hover:underline dark:hover:text-blue-400">Beranda</a>

    @foreach ($segments as $index => $segment)
        @php
            // Bangun URL untuk link saat ini
            $url .= '/' . $segment;
            $isLast = $index === count($segments) - 1;

            // Tentukan judul untuk segmen
            if ($isLast && isset($titleForLastSegment)) {
                $title = $titleForLastSegment;
            } else {
                $title = $routeNames[$segment] ?? Str::title(str_replace('-', ' ', $segment));
            }
        @endphp

        <span class="mx-2">/</span>

        @if ($isLast)
            <span class="text-blue-700 dark:text-blue-400 font-medium">{{ $title }}</span>
        @else
            {{-- PERBAIKAN: Gunakan $url, bukan $accumulatedUrl --}}
            <a href="{{ $url }}" class="hover:underline dark:hover:text-blue-400">{{ $title }}</a>
        @endif
    @endforeach
</nav>
