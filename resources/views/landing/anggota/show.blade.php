@extends('layouts.app')

@section('title', isset($anggota) ? 'Detail Anggota - ' . $anggota->nama : 'Detail Anggota')

@section('content')
<div class="max-w-3xl mx-auto p-6 md:p-8 my-12 md:my-16 bg-white dark:bg-gray-800 rounded-xl shadow-xl dark:shadow-slate-700 transition-colors duration-300">

    {{-- Foto Profil & Nama --}}
    <div class="flex flex-col items-center mb-8">
        <img 
            src="{{ isset($anggota) && $anggota->foto ? asset('storage/' . $anggota->foto) : asset('images/default-profile.png') }}"
            alt="{{ $anggota->nama ?? 'Foto Profil' }}"
            class="w-32 h-32 md:w-40 md:h-40 object-cover rounded-full shadow-lg border-4 border-white dark:border-gray-700 mb-4"
        >
        <h1 class="text-3xl md:text-4xl font-bold text-center text-gray-900 dark:text-white transition-colors duration-300">{{ $anggota->nama ?? 'Nama Anggota' }}</h1>
    </div>

    {{-- Detail Informasi --}}
    <div class="space-y-5 text-gray-800 dark:text-gray-300 transition-colors duration-300">
        <div>
            <span class="font-semibold text-gray-700 dark:text-gray-400">Tipe:</span>
            @if(isset($anggota))
            <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full
                {{ $anggota->tipe === 'pengajar' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' }} transition-colors duration-300">
                {{ ucfirst($anggota->tipe) }}
            </span>
            @else
            <span>-</span>
            @endif
        </div>

        <div>
            <span class="font-semibold text-gray-700 dark:text-gray-400">Jenis Kelamin:</span>
            {{ isset($anggota) ? ($anggota->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan') : '-' }}
        </div>

        <div>
            <span class="font-semibold text-gray-700 dark:text-gray-400">Telepon:</span>
            {{ $anggota->telepon ?? '-' }}
        </div>

        @if(isset($anggota) && $anggota->profil)
        <div class="pt-3">
            <h2 class="text-xl font-semibold mt-6 mb-2 text-gray-900 dark:text-white transition-colors duration-300">Profil</h2>
            <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line leading-relaxed transition-colors duration-300">{{ $anggota->profil }}</p>
        </div>
        @endif
    </div>

    {{-- Tombol Kembali --}}
    <div class="mt-10 text-center">
        <a href="{{ route('anggota.index') }}"
           class="inline-flex items-center bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 text-white px-6 py-2.5 rounded-lg shadow-md hover:shadow-lg transition-all duration-300 font-semibold">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Daftar Anggota
        </a>
    </div>
</div>
@endsection
