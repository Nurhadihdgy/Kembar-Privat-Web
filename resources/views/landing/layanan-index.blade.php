@extends('layouts.app')
@section('title', 'Layanan Kami')
@section('content')
    {{-- layanan Kami --}}
    <section class="my-16 bg-white-900 dark:bg-gray py-16 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4">
            <x-breadcrumb />
            <h2
                class="text-4xl md:text-5xl font-bold text-center mb-12 text-gray-800 dark:text-yellow-400">
                Layanan Kami
            </h2>

            <div class="flex overflow-x-auto space-x-4 md:grid md:grid-cols-3 md:space-x-0 md:gap-8 hide-scrollbar">
                @foreach ($layanans as $layanan)
                    {{-- Kartu layanan --}}
                    <div
                        class="min-w-[250px] md:min-w-0 bg-white dark:bg-gray-800 rounded-xl shadow-md dark:shadow-slate-700 overflow-hidden hover:shadow-xl dark:hover:shadow-slate-600 hover:scale-105 hover:relative hover:z-10 transition-all duration-300">
                        <img src="{{ asset('storage/' . $layanan->gambar) }}" alt="{{ $layanan->nama }}"
                            class="h-56 w-full object-cover">
                        <div class="p-4">
                            @if ($layanan->label)
                                <span
                                    class="inline-block bg-green-100 text-green-800 dark:bg-blue-900 dark:text-blue-200 text-xs px-2 py-1 rounded-full font-semibold mb-2 transition-colors duration-300">
                                    {{ $layanan->label }}
                                </span>
                            @endif
                            <h3 class="text-xl font-semibold text-gray-800 dark:text-white transition-colors duration-300">
                                {{ $layanan->nama }}</h3>
                            <p class="text-green-600 dark:text-green-400 font-medium mt-1 transition-colors duration-300">
                                Rp {{ number_format($layanan->harga, 0, ',', '.') }} / Pertemuan
                            </p>
                            <a href="{{ route('layanan.show', $layanan->slug) }}"
                                class="inline-block mt-3 text-sm text-blue-600 dark:text-yellow-400 font-semibold hover:underline dark:hover:text-gray-300 transition-colors duration-300">
                                Selengkapnya &rarr;
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </section>
@endsection
