@extends('layouts.app')
@section('title', 'Tulis Ulasan Anda')
@section('content')
<section class="my-16 dark:bg-gray-900 py-12">
    <div class="max-w-2xl mx-auto px-4">
        <div class="mb-6">
            <x-breadcrumb />
        </div>
        <h1 class="text-3xl md:text-4xl font-bold text-center mb-4 text-gray-800 dark:text-yellow-400">Tulis Ulasan Anda</h1>
        <p class="text-center text-gray-600 dark:text-gray-400 mb-10">Bagikan pengalaman Anda bersama kami untuk membantu yang lain.</p>
        
        <form action="{{ route('ulasan.store') }}" method="POST" class="bg-white dark:bg-gray-800 p-6 md:p-8 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 space-y-6">
            @csrf
            
            {{-- Nama Pengulas --}}
            <div>
                <label for="nama_pengulas" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nama Anda</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" /></svg>
                    </div>
                    <input type="text" name="nama_pengulas" id="nama_pengulas" value="{{ old('nama_pengulas') }}" required placeholder="Contoh: Abdullah" class="w-full pl-10 pr-4 py-3 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500/50 dark:focus:border-yellow-400 dark:focus:ring-yellow-400/50 transition duration-150">
                </div>
                @error('nama_pengulas')
                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                @enderror
            </div>

            {{-- Layanan yang Diikuti --}}
            <div>
                <label for="layanan_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Layanan yang Diikuti (Opsional)</label>
                 <select name="layanan_id" id="layanan_id" class="w-full py-3 px-4 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500/50 dark:focus:border-yellow-400 dark:focus:ring-yellow-400/50 transition duration-150">
                    <option value="">Pilih layanan...</option>
                    @foreach($layanans as $id => $nama)
                        <option value="{{ $id }}" {{ old('layanan_id') == $id ? 'selected' : '' }}>{{ $nama }}</option>
                    @endforeach
                </select>
                @error('layanan_id')
                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                @enderror
            </div>

            {{-- Rating --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Rating Anda</label>
                <div class="flex items-center space-x-2" x-data="{ rating: {{ old('rating', 5) }} }">
                    <input type="hidden" name="rating" :value="rating">
                    @for ($i = 1; $i <= 5; $i++)
                        <button type="button" @click="rating = {{ $i }}" class="focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-gray-800 focus:ring-yellow-400 rounded-full p-1 transition-transform hover:scale-110">
                            <svg class="w-8 h-8" :class="rating >= {{ $i }} ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600 hover:text-yellow-300'" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                        </button>
                    @endfor
                </div>
                 @error('rating')
                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                @enderror
            </div>

            {{-- Ulasan --}}
            <div>
                <label for="ulasan" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Ulasan Anda</label>
                <textarea name="ulasan" id="ulasan" rows="5" required placeholder="Tuliskan pengalaman Anda di sini..." class="w-full px-4 py-3 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500/50 dark:focus:border-yellow-400 dark:focus:ring-yellow-400/50 transition duration-150">{{ old('ulasan') }}</textarea>
                @error('ulasan')
                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                @enderror
            </div>
            
            {{-- Tombol Submit --}}
            <div>
                <button type="submit" class="inline-flex items-center justify-center w-full bg-blue-600 text-white py-3 px-4 border border-transparent rounded-lg shadow-sm font-semibold hover:bg-blue-700 dark:bg-yellow-500 dark:text-gray-900 dark:hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-gray-800 focus:ring-blue-500 transition-all duration-300">
                     <svg class="w-5 h-5 mr-2 -ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                    </svg>
                    Kirim Ulasan
                </button>
            </div>
        </form>
    </div>
</section>
@endsection