@extends('layouts.app')

@section('title', 'Ulasan dan Testimoni')

@section('content')
<section class="my-16 dark:bg-gray-900 py-12">
    <div class="max-w-7xl mx-auto px-4">
        <div class="mb-6">
            <x-breadcrumb />
        </div>
        <h1 class="text-3xl md:text-4xl font-bold text-center mb-4 text-gray-800 dark:text-yellow-400">Ulasan & Testimoni</h1>
        <p class="text-center text-gray-600 dark:text-gray-400 mb-10">Lihat apa kata mereka yang telah bergabung dengan kami.</p>

        {{-- Notifikasi Sukses --}}
        @if (session('success'))
            <div class="bg-green-100 dark:bg-green-900 border-l-4 border-green-500 text-green-700 dark:text-green-200 p-4 rounded-md shadow-md mb-8" role="alert">
                <p class="font-bold">Berhasil!</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        {{-- Ringkasan Rating --}}
        @if($totalUlasan > 0)
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg mb-10 flex flex-col md:flex-row items-center gap-8 border border-gray-200 dark:border-gray-700">
            <div class="text-center flex-shrink-0">
                <p class="text-gray-600 dark:text-gray-400">Rating Rata-rata</p>
                <p class="text-5xl font-bold text-gray-900 dark:text-white">{{ number_format($averageRating, 1) }} <span class="text-3xl text-gray-400">/ 5.0</span></p>
                <div class="flex justify-center mt-1">
                    @for ($i = 1; $i <= 5; $i++)
                        <span class="text-2xl {{ $i <= round($averageRating) ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600' }}">⭐</span>
                    @endfor
                </div>
                <p class="text-sm text-gray-500 mt-1">Dari {{ $totalUlasan }} Ulasan</p>
            </div>
            <div class="w-full flex-1">
                @for ($i = 5; $i >= 1; $i--)
                    @php
                        $count = $ratingCounts->get($i, 0);
                        $percentage = ($totalUlasan > 0) ? ($count / $totalUlasan) * 100 : 0;
                    @endphp
                    <div class="flex items-center gap-3 mb-1">
                        <span class="text-sm text-yellow-400 flex items-center w-8">{{ $i }} <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg></span>
                        <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-2.5">
                            <div class="bg-yellow-400 h-2.5 rounded-full" style="width: {{ $percentage }}%"></div>
                        </div>
                        <span class="text-sm text-gray-500 dark:text-gray-400 w-10 text-right">{{ $count }}</span>
                    </div>
                @endfor
            </div>
        </div>
        @endif

        {{-- Grid Ulasan --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($ulasans as $ulasan)
                <div class="flex flex-col h-full bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 rounded-full bg-blue-500 text-white flex items-center justify-center text-lg font-bold mr-4 flex-shrink-0">
                            {{ strtoupper(substr($ulasan->nama_pengulas, 0, 1)) }}
                        </div>
                        <div>
                            <p class="font-bold text-gray-900 dark:text-white">{{ $ulasan->nama_pengulas }}</p>
                            @if($ulasan->layanan)
                                <p class="text-xs text-blue-600 dark:text-blue-400 font-semibold">{{ $ulasan->layanan->nama }}</p>
                            @endif
                        </div>
                    </div>
                    <div class="flex mb-3">
                        @for ($i = 1; $i <= 5; $i++)
                            <span class="text-xl {{ $i <= $ulasan->rating ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600' }}">⭐</span>
                        @endfor
                    </div>
                    <p class="text-gray-700 dark:text-gray-300 italic flex-grow">"{{ $ulasan->ulasan }}"</p>
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-4 text-right">{{ $ulasan->created_at->format('d M Y') }}</p>
                </div>
            @empty
                <p class="text-center text-gray-500 dark:text-gray-400 col-span-full">Belum ada ulasan yang ditampilkan.</p>
            @endforelse
        </div>

        {{-- Pagination Links --}}
        <div class="mt-10">
            {{ $ulasans->links() }}
        </div>
        
        {{-- Tombol untuk Menulis Ulasan Baru --}}
        <div class="mt-12 text-center">
            <a href="{{ route('ulasan.create') }}"
               class="inline-block bg-blue-600 hover:bg-blue-700 dark:bg-yellow-500 dark:hover:bg-yellow-600 text-white dark:text-gray-900 px-6 py-2 rounded-lg transition-all duration-300 font-semibold shadow-lg">
                Tulis Ulasan Anda
            </a>
        </div>
    </div>
</section>
@endsection
