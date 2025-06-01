@extends('layouts.app')

@section('content')
    <section class="my-16 dark:bg-gray-900 py-12 rounded-lg transition-colors duration-300">
        <x-breadcrumb />
        <div class="max-w-7xl mx-auto px-4"> {{-- max-w-7xl diterapkan di sini agar padding section konsisten --}}
            <h1
                class="text-3xl md:text-4xl font-bold text-center mb-10 text-gray-800 dark:text-yellow-400 transition-colors duration-300">
                Daftar Anggota Kembar Privat
            </h1>

            @if ($anggota->count())
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    @foreach ($anggota as $item)
                        <a href="{{ route('anggota.show', $item->id) }}"
                            class="block bg-white dark:bg-gray-800 rounded-lg shadow-md dark:shadow-slate-700 hover:shadow-lg dark:hover:shadow-slate-600 transition-all duration-300 overflow-hidden hover:scale-105">

                            {{-- Foto Profil --}}
                            {{-- Container untuk foto agar konsisten dan foto bisa di tengah --}}
                            <div
                                class="w-full h-56 flex justify-center items-center bg-gray-100 dark:bg-gray-700 transition-colors duration-300">
                                <img src="{{ $item->foto ? asset('storage/' . $item->foto) : asset('images/default-profile.png') }}"
                                    alt="{{ $item->nama }}" class="w-40 h-40 object-cover rounded-full shadow-md">
                            </div>

                            {{-- Info Anggota --}}
                            <div class="p-5">
                                <h3
                                    class="text-lg font-bold text-gray-800 dark:text-white mb-1 transition-colors duration-300">
                                    {{ $item->nama }}</h3>

                                <p class="text-sm mb-1">
                                    <strong class="dark:text-gray-300">Tipe:</strong>
                                    <span
                                        class="inline-block px-2 py-0.5 text-xs font-medium rounded 
                                    {{ $item->tipe == 'pengajar' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' }} transition-colors duration-300">
                                        {{ ucfirst($item->tipe) }}
                                    </span>
                                </p>

                                <p class="text-sm text-gray-600 dark:text-gray-400 transition-colors duration-300">
                                    <strong>Jenis Kelamin:</strong>
                                    {{ $item->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                </p>
                                <p class="text-sm text-gray-600 dark:text-gray-400 transition-colors duration-300">
                                    <strong>Telepon:</strong> {{ $item->telepon }}
                                </p>

                                <p
                                    class="mt-3 text-sm text-gray-700 dark:text-gray-300 line-clamp-3 transition-colors duration-300">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($item->profil), 120) }}
                                </p>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 dark:text-gray-400 text-center transition-colors duration-300">Belum ada anggota
                    yang ditampilkan.</p>
            @endif

        </div>
    </section>
@endsection
