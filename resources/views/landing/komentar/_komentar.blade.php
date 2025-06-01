{{-- 
  File: resources/views/landing/komentar/_komentar.blade.php
  Variabel yang diharapkan: $komentar (object), $artikel_id (int, ID artikel utama)
--}}
<div class="mb-4 {{ $komentar->parent_id ? 'ml-6 md:ml-10' : 'ml-0' }}">
    <div class="p-3 bg-gray-100 dark:bg-gray-800 rounded-lg shadow transition-colors duration-300">
        <div class="flex items-start space-x-3">
            {{-- Avatar (Contoh, bisa Anda tambahkan jika punya) --}}
            {{-- <img src="https://via.placeholder.com/40" alt="Avatar" class="w-10 h-10 rounded-full"> --}}
            <div class="flex-1">
                <p class="font-semibold text-gray-800 dark:text-white">{{ $komentar->nama }}</p>
                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">
                    {{ $komentar->created_at->diffForHumans() }}
                </p>
                <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $komentar->isi }}</p>

                {{-- Tombol balas --}}
                <div x-data="{ openReply: false }" class="mt-2">
                    <button @click="openReply = !openReply"
                            class="text-sm text-blue-600 dark:text-blue-400 hover:underline dark:hover:text-blue-300 transition-colors duration-300">
                        Balas
                    </button>

                    {{-- Form balasan --}}
                    <form x-show="openReply" x-cloak 
                          action="{{ route('komentar.store', ['artikel' => $artikel_id]) }}" {{-- $artikel_id dari parent scope --}}
                          method="POST" class="mt-2 space-y-2">
                        @csrf
                        <input type="hidden" name="artikel_id" value="{{ $artikel_id }}"> {{-- $artikel_id dari parent scope --}}
                        <input type="hidden" name="parent_id" value="{{ $komentar->id }}">
                        
                        <div>
                            <label for="nama_balasan_{{ $komentar->id }}" class="sr-only">Nama</label>
                            <input type="text" name="nama" id="nama_balasan_{{ $komentar->id }}" placeholder="Nama Anda" 
                                   class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-1.5 text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-500 dark:focus:border-blue-500 transition-colors duration-300" required>
                        </div>
                        <div>
                            <label for="isi_balasan_{{ $komentar->id }}" class="sr-only">Balasan</label>
                            <textarea name="isi" id="isi_balasan_{{ $komentar->id }}" rows="2" placeholder="Tulis balasan Anda..." 
                                      class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-1.5 text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-500 dark:focus:border-blue-500 transition-colors duration-300"
                                      required></textarea>
                        </div>
                        <button type="submit"
                                class="bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700 text-white px-3 py-1.5 rounded text-sm font-semibold transition-colors duration-300">
                            Kirim Balasan
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Dropdown untuk melihat balasan --}}
        @if ($komentar->replies && $komentar->replies->count())
            <div x-data="{ showReplies: false }" class="mt-2">
                <button @click="showReplies = !showReplies" class="text-xs text-gray-500 hover:underline">
                    Lihat {{ $komentar->replies->count() }} balasan
                </button>

                <div x-show="showReplies" x-cloak class="mt-2 ml-4 border-l border-gray-300 pl-4">
                    @foreach ($komentar->replies as $reply)
                        @include('landing.komentar._komentar', ['komentar' => $reply])
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
