@extends('layouts.app') {{-- Asumsi kamu punya layout app.blade.php --}}

@section('title', 'Tentang Kami')

@section('content')

{{-- Section utama --}}
<section class="my-10 md:my-16 px-4">
    <div class="max-w-5xl mx-auto"> {{-- Kontainer untuk membatasi lebar dan centering --}}
        
        {{-- Breadcrumb --}}
        <div class="mb-6"> {{-- Beri margin bawah untuk breadcrumb --}}
            <x-breadcrumb />
        </div>

        <h2 class="text-4xl md:text-5xl font-bold text-center mb-12 text-gray-800 dark:text-yellow-400">
            Tentang Kami
        </h2>

        <div class="prose prose-lg mb-8 dark:prose-invert max-w-none text-gray-700 dark:text-gray-300 font-semibold transition-colors duration-300">
            {!! $tentangKami->isi !!}
        </div>

        @if ($tentangKami->gambar)
                @php
                    $ext = pathinfo($tentangKami->gambar, PATHINFO_EXTENSION);
                    $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'webp']);
                    $isVideo = in_array($ext, ['mp4', 'webm', 'ogg']);
                @endphp

                <div class="w-full">
                    @if ($isImage)
                        <img src="{{ asset('storage/' . $tentangKami->gambar) }}" alt="Tentang Kami"
                            class="rounded-2xl shadow-xl w-full object-cover h-auto transition-transform hover:scale-105 duration-500 ease-in-out">
                    @elseif ($isVideo)
                        <video autoplay muted loop playsinline class="rounded-2xl shadow-xl w-full h-auto">
                            <source src="{{ asset('storage/' . $tentangKami->gambar) }}" type="video/{{ $ext }}">
                            Browser Anda tidak mendukung video.
                        </video>
                    @endif
                </div>
            @endif
    </div>
</section>
@endsection
