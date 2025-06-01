@extends('layouts.app')

@section('title', isset($layanan) ? 'Detail Layanan - ' . $layanan->nama : 'Detail Layanan')

@section('content')
<section class="max-w-5xl mx-auto px-4 py-12">
    {{-- Breadcrumb --}}
    <div class="mb-6"> {{-- Wrapper untuk breadcrumb agar bisa diberi margin --}}
        <x-breadcrumb />
    </div>

    <div class="flex flex-col md:flex-row gap-8 md:gap-10">
        {{-- Kolom Gambar --}}
        <div class="md:w-1/2">
            @if(isset($layanan) && $layanan->gambar)
                <img src="{{ asset('storage/' . $layanan->gambar) }}" alt="{{ $layanan->nama ?? 'Gambar Layanan' }}" 
                     class="rounded-xl shadow-xl w-full h-auto object-cover aspect-square md:aspect-auto">
            @else
                {{-- Placeholder jika tidak ada gambar --}}
                <div class="rounded-xl shadow-xl w-full bg-gray-200 dark:bg-gray-700 aspect-square flex items-center justify-center">
                    <svg class="w-24 h-24 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
            @endif
        </div>

        {{-- Kolom Informasi Layanan --}}
        <div class="md:w-1/2">
            {{-- Label/Kategori Layanan --}}
            @if (isset($layanan) && $layanan->label)
                <span class="inline-block bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 text-xs px-3 py-1 rounded-full font-semibold mb-3 transition-colors duration-300">
                    {{ $layanan->label }}
                </span>
            @endif

            <h1 class="text-3xl lg:text-4xl font-bold text-gray-800 dark:text-white mb-3 transition-colors duration-300">
                {{ $layanan->nama ?? 'Nama Layanan Tidak Tersedia' }}
            </h1>
            
            @if(isset($layanan) && $layanan->harga)
            <p class="text-xl text-green-600 dark:text-green-400 font-semibold mb-4 transition-colors duration-300">
                Rp {{ number_format($layanan->harga, 0, ',', '.') }} / Pertemuan
            </p>
            @endif
            
            {{-- Deskripsi Layanan (Prose untuk styling dari CMS) --}}
            <div class="text-gray-700 dark:text-gray-300 leading-relaxed prose dark:prose-invert max-w-none transition-colors duration-300">
                {!! $layanan->deskripsi ?? '<p>Deskripsi layanan tidak tersedia.</p>' !!}
            </div>

            {{-- Tombol Aksi (Contoh: Hubungi Kami) --}}
            <div class="mt-8">
                <a href="https://wa.me/081286895593" {{-- Arahkan ke section kontak di halaman kontak --}}
                   class="inline-block bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 text-white px-6 py-3 rounded-lg transition-all duration-300 font-semibold shadow-md">
                    Hubungi Kami untuk Info Lebih Lanjut
                </a>
            </div>
        </div>
    </div>
</section>
@endsection

