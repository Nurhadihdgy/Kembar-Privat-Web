@extends('layouts.app')

@section('title', 'Galeri Kegiatan') {{-- Mengubah judul agar lebih sesuai --}}

@section('content')
    <section class="my-16 dark:bg-gray-900 py-12 rounded-lg transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4">
            <x-breadcrumb />
            <h1 class="text-3xl md:text-4xl font-bold text-center mb-10 text-gray-800 dark:text-yellow-400 transition-colors duration-300">Galeri Kegiatan</h1>

            @php
                $galeriItems = $galeris->map(function ($item) {
                    $filePath = $item->foto; // Asumsi 'foto' adalah nama kolom di DB
                    $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                    $type = 'image'; // Default type
                    if (in_array($extension, ['mp4', 'webm', 'ogg'])) {
                        $type = 'video';
                    }

                    return [
                        'src' => asset('storage/' . $filePath),
                        'title' => $item->judul ?? 'Tanpa Judul',
                        'description' => $item->deskripsi ?? '',
                        'type' => $type, // Tambahkan tipe media
                        'original_item' => $item 
                    ];
                })->values();
            @endphp

            <div x-data="{
                open: false,
                currentIndex: 0,
                items: @js($galeriItems),
            
                show(index) {
                    this.currentIndex = index;
                    this.open = true;
                },
                closeModal() {
                    this.open = false;
                },
                next() {
                    this.currentIndex = (this.currentIndex + 1) % this.items.length;
                },
                prev() {
                    this.currentIndex = (this.currentIndex - 1 + this.items.length) % this.items.length;
                },
                get currentItem() {
                    return this.items[this.currentIndex] || { src: '', title: '', description: '', type: 'image' };
                }
            }" x-init="console.log('Galeri Alpine.js siap', items)">

                {{-- Grid Galeri --}}
                @if ($galeris->count() > 0)
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 md:gap-6">
                        @foreach ($galeris as $i => $item)
                            @php
                                $filePathGrid = $item->foto;
                                $extensionGrid = strtolower(pathinfo($filePathGrid, PATHINFO_EXTENSION));
                                $isImageGrid = in_array($extensionGrid, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                $isVideoGrid = in_array($extensionGrid, ['mp4', 'webm', 'ogg']);
                            @endphp
                            <div class="cursor-pointer rounded-lg overflow-hidden shadow-md dark:shadow-slate-700 bg-white dark:bg-gray-800 group hover:shadow-lg dark:hover:shadow-slate-600 transition-all duration-300"
                                 @click="show({{ $i }})">
                                <div class="w-full h-48 overflow-hidden bg-gray-100 dark:bg-gray-700 relative"> {{-- Kontainer ini memastikan rasio aspek 1:1 (persegi) --}}
                                    @if($isImageGrid)
                                        <img src="{{ asset('storage/' . $filePathGrid) }}" alt="{{ $item->judul ?? 'Galeri' }}" class="object-cover w-full h-full group-hover:scale-110 transition-transform duration-300">
                                    @elseif($isVideoGrid)
                                        <video class="object-cover w-full h-full group-hover:scale-110 transition-transform duration-300" autoplay muted loop playsinline>
                                            <source src="{{ asset('storage/' . $filePathGrid) }}" type="video/{{ $extensionGrid }}">
                                            Browser Anda tidak mendukung tag video.
                                        </video>
                                        {{-- Ikon Play untuk Video Thumbnail --}}
                                        <div class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-20 group-hover:bg-opacity-10 transition-opacity duration-300">
                                            {{-- Ukuran ikon play disesuaikan sedikit --}}
                                            <svg class="w-8 h-8 text-white opacity-60" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path></svg>
                                        </div>
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-gray-100 dark:bg-gray-700">
                                            <p class="text-xs text-gray-500 dark:text-gray-400 p-2">Format tidak didukung</p>
                                        </div>
                                    @endif
                                </div>
                                <div class="p-3">
                                    <p class="text-sm text-gray-800 dark:text-gray-200 font-medium truncate text-center transition-colors duration-300">
                                        {{ $item->judul ?? 'Tanpa Judul' }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-center text-gray-600 dark:text-gray-400">Belum ada item di galeri.</p>
                @endif

                {{-- Modal Lightbox --}}
                <div class="fixed inset-0 bg-black bg-opacity-80 flex items-center justify-center z-[9999]" x-show="open"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     @keydown.window.escape="closeModal()"
                     x-cloak
                     style="padding: 1rem;">

                    <div class="relative bg-white dark:bg-gray-800 p-4 rounded-lg shadow-xl max-w-3xl w-full max-h-[90vh] flex flex-col" @click.away="closeModal()">
                        {{-- Tombol Tutup --}}
                        <button @click="closeModal()"
                                class="absolute top-3 right-3 text-gray-600 dark:text-gray-300 hover:text-red-500 dark:hover:text-red-400 text-3xl font-bold z-10">&times;</button>
                        
                        {{-- Konten Modal (Gambar atau Video) --}}
                        <div class="flex-grow overflow-auto flex flex-col items-center justify-center">
                            <template x-if="currentItem.type === 'image'">
                                <img :src="currentItem.src" class="rounded-md shadow-lg max-h-[70vh] max-w-full object-contain mb-3">
                            </template>
                            <template x-if="currentItem.type === 'video'">
                                <video :src="currentItem.src" class="rounded-md shadow-lg max-h-[70vh] max-w-full" controls autoplay playsinline>
                                    Browser Anda tidak mendukung tag video.
                                </video>
                            </template>
                        </div>
                        
                        {{-- Judul & Deskripsi di Modal --}}
                        <div class="mt-2 text-center py-2">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white" x-text="currentItem.title"></h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400" x-text="currentItem.description" x-show="currentItem.description"></p>
                        </div>

                        {{-- Tombol Navigasi (hanya jika ada lebih dari 1 item) --}}
                        <template x-if="items.length > 1">
                            <div>
                                <button @click="prev()"
                                    class="absolute left-1 md:left-3 top-1/2 -translate-y-1/2 bg-black bg-opacity-30 hover:bg-opacity-50 text-white p-2 rounded-full text-3xl md:text-4xl transition-opacity duration-300">
                                    &#10094;
                                </button>
                                <button @click="next()"
                                    class="absolute right-1 md:right-3 top-1/2 -translate-y-1/2 bg-black bg-opacity-30 hover:bg-opacity-50 text-white p-2 rounded-full text-3xl md:text-4xl transition-opacity duration-300">
                                    &#10095;
                                </button>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
