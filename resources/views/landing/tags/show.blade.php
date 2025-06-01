@extends('layouts.app')

@section('title', 'Artikel dengan tag: ' . $tag->nama)

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-8">
        <x-breadcrumb />
        <h1 class="text-2xl md:text-3xl font-light mb-6">
            Artikel dengan Tag: 
            <span class="inline-block bg-blue-600 text-white text-sm md:text-base px-3 py-1 rounded-md font-semibold">
                {{ $tag->nama }}
            </span>
        </h1>

        @if ($artikels->count())
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                @foreach ($artikels as $artikel)
                    <a href="{{ route('artikel.show', $artikel->slug) }}" class="group">
                        <div class="bg-white rounded-lg shadow hover:shadow-md transition-all duration-300 h-full flex flex-col justify-between">
                            <div class="p-5">
                                <h2 class="text-lg font-bold text-gray-800 group-hover:text-blue-600 transition-colors">
                                    {{ $artikel->judul }}
                                </h2>
                                <p class="text-sm text-gray-500 mt-1">
                                    <i class="bi bi-calendar-event mr-1"></i>
                                    {{ $artikel->published_at->format('d M Y') }}
                                </p>
                                <p class="text-gray-700 mt-3 text-sm">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($artikel->isi), 120) }}
                                </p>
                            </div>
                            <div class="px-5 pb-5 text-right">
                                <span class="text-blue-600 text-sm font-medium hover:underline">
                                    Baca Selengkapnya &rarr;
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="flex justify-center">
                {{ $artikels->links() }}
            </div>
        @else
            <div class="bg-blue-50 text-blue-800 border border-blue-200 p-4 rounded-md">
                <i class="bi bi-info-circle mr-2"></i> Belum ada artikel untuk tag ini.
            </div>
        @endif
    </div>
@endsection
