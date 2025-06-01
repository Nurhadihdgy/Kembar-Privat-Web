@extends('layouts.app')

@section('content')
<section class="my-16 px-4 max-w-7xl mx-auto dark:bg-gray-900 py-12 rounded-lg transition-colors duration-300">
    <x-breadcrumb />
        <h2
            class="text-4xl md:text-5xl font-bold text-center mb-12 text-gray-800 dark:text-yellow-400 transition-colors duration-300">
            Artikel / Blog
        </h2>

        {{-- Wrapper untuk artikel: flex dan scroll horizontal di mobile, grid di desktop --}}
        <div class="flex overflow-x-auto space-x-4 pb-4 md:grid md:grid-cols-3 md:space-x-0 md:gap-8 hide-scrollbar">
            @foreach ($artikels as $artikel)
                <a href="{{ route('artikel.show', $artikel->slug) }}"
                    class="block min-w-[280px] md:min-w-0 bg-white dark:bg-gray-800 shadow-md dark:shadow-slate-700 rounded-xl overflow-hidden hover:shadow-lg dark:hover:shadow-slate-600 transition-all duration-300 hover:scale-105">
                    @if ($artikel->gambar)
                        <img src="{{ asset('storage/' . $artikel->gambar) }}" class="w-full h-60 object-cover"
                            alt="{{ $artikel->judul }}">
                    @else
                        {{-- Placeholder jika tidak ada gambar --}}
                        <div class="w-full h-60 bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                            <svg class="w-16 h-16 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                    @endif
                    <div class="p-4">
                        <h3 class="text-xl font-bold text-gray-800 dark:text-white transition-colors duration-300">
                            {{ $artikel->judul }}</h3>
                        <p
                            class="text-sm text-gray-500 dark:text-gray-400 mt-1 transition-colors duration-300 line-clamp-3">
                            {{ \Illuminate\Support\Str::limit(strip_tags($artikel->isi), 120) }}</p>
                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-2 transition-colors duration-300">
                            {{ $artikel->published_at->format('d M Y') }}</p>
                    </div>
                </a>
            @endforeach
        </div>

    </section>
@endsection
