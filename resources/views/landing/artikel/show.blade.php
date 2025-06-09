@extends('layouts.app')

@section('title', isset($artikel) ? $artikel->judul : 'Detail Artikel')

@section('content')
<section class="max-w-4xl mx-auto px-4 py-12">
    {{-- Breadcrumbs --}}
    <div class="mb-6">
        <x-breadcrumb />
    </div>

    <div class="mb-6 text-gray-500 dark:text-gray-400 text-sm transition-colors duration-300">
        {{ isset($artikel) ? \Carbon\Carbon::parse($artikel->published_at)->format('d M Y') : '' }}
    </div>

    <h1 class="text-3xl md:text-4xl font-bold mb-6 text-gray-800 dark:text-white transition-colors duration-300">
        {{ $artikel->judul ?? 'Judul Artikel Tidak Tersedia' }}
    </h1>

    @if (isset($artikel) && $artikel->gambar)
        <div class="rounded-xl mb-6 overflow-hidden shadow-lg">
            <img src="{{ asset('storage/' . $artikel->gambar) }}" class="w-full h-auto object-cover"
                 alt="{{ $artikel->judul }}">
        </div>
    @endif

    {{-- Konten Artikel dari CMS/Rich Editor --}}
    <div class="prose prose-lg dark:prose-invert max-w-none text-gray-700 dark:text-gray-300 transition-colors duration-300">
        {!! $artikel->isi ?? '<p>Konten artikel tidak tersedia.</p>' !!}
    </div>

    {{-- Tags --}}
    @if (isset($artikel->tags) && $artikel->tags instanceof \Illuminate\Database\Eloquent\Collection && $artikel->tags->count() > 0)
    <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700 transition-colors duration-300">
        <h4 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-3 transition-colors duration-300">Tags:</h4>
        <div class="flex flex-wrap gap-2">
            @foreach ($artikel->tags as $tag)
                <a href="{{ route('tag.show', $tag->slug) }}"
                   class="text-sm bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 px-3 py-1 rounded-full hover:bg-blue-200 dark:hover:bg-blue-800 transition-colors duration-300">
                    #{{ $tag->nama }}
                </a>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Komentar --}}
    <div class="mt-10 pt-6 border-t border-gray-200 dark:border-gray-700 transition-colors duration-300">
        <h3 class="font-bold text-xl md:text-2xl text-gray-800 dark:text-white mb-6 transition-colors duration-300">Komentar</h3>

        {{-- Komentar utama dan balasan --}}
        <div class="mt-4 space-y-6">
            @if(isset($artikel) && $artikel->komentars()->whereNull('parent_id')->aktif()->count() > 0)
                @foreach ($artikel->komentars()->whereNull('parent_id')->aktif()->orderBy('created_at', 'desc')->get() as $komentar)
                    {{-- Asumsi _komentar.blade.php sudah di-style untuk dark mode --}}
                    @include('landing.komentar._komentar', ['komentar' => $komentar, 'artikel_id' => $artikel->id])
                @endforeach
            @else
                <p class="text-gray-500 dark:text-gray-400">Belum ada komentar.</p>
            @endif
        </div>
    </div>
</section>

{{-- Form Komentar Baru --}}
<section class="max-w-4xl mx-auto px-4 pb-12 pt-6">
    <h3 class="font-bold text-xl md:text-2xl text-gray-800 dark:text-white mb-6 transition-colors duration-300">Beri Komentar</h3>
    <form action="{{ isset($artikel) ? route('komentar.store', $artikel->id) : '#' }}" method="POST" class="mt-4 bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md dark:shadow-slate-700 transition-colors duration-300">
        @csrf
        <input type="hidden" name="parent_id" value=""> {{-- Untuk komentar utama, parent_id kosong/null --}}
        
        <div class="mb-4">
            <label for="nama_komentar" class="block font-semibold mb-1 text-gray-700 dark:text-gray-300 transition-colors duration-300">Nama:</label>
            <input type="text" name="nama" id="nama_komentar" required
                   class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-500 dark:focus:border-blue-500 transition-colors duration-300">
        </div>
        
        <div class="mt-4 mb-4">
            <label for="isi_komentar" class="block font-semibold mb-1 text-gray-700 dark:text-gray-300 transition-colors duration-300">Komentar:</label>
            <textarea name="isi" id="isi_komentar" rows="4" required 
                      class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-500 dark:focus:border-blue-500 transition-colors duration-300"></textarea>
        </div>
        
        <button type="submit" 
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 dark:text-white transition-all duration-300 font-semibold shadow-md">
            Kirim Komentar
        </button>
    </form>
</section>
@endsection
