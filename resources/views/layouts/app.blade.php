<!DOCTYPE html>
<html lang="id" x-data="darkModeToggle()" :class="{ 'dark': isDark }" x-init="init()">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Kembar Privat Al Qur\'an')</title>
    {{-- Favicon Links --}}
        <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
        <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    @vite('resources/css/app.css')

    {!! SEOMeta::generate() !!}

    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <script src="//unpkg.com/alpinejs" defer></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css">

    <script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "EducationalOrganization",
  "name": "Kembar Privat Al-Quran",
  "url": "{{ url('/') }}",
  "logo": "{{ asset('images/logo.png') }}",
  "description": "Layanan les privat Al-Quran dengan guru profesional, di rumah Anda.",
}
</script>


    @stack('styles')
</head>

<body class="bg-white font-sans transition-colors duration-300 dark:bg-gray-900 dark:text-gray-200">

    <header class="sticky top-0 z-50 shadow-md bg-white dark:bg-gray-800" x-data="{ open: false }">
        <nav class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            {{-- Logo dan Judul --}}
            <a href="{{ url('/') }}" class="flex items-center space-x-2">
                <img :src="isDark ? '{{ asset('images/logo2.png') }}' : '{{ asset('images/logo.png') }}'" alt="Logo"
                    class="h-20 w-auto" />
                <span class="text-2xl font-bold"
                    :class="isDark ? 'text-yellow-400' : 'text-blue-700 dark:text-blue-400'">
                    Kembar Privat Al-Quran
                </span>
            </a>


            {{-- Menu Desktop --}}
            <ul class="hidden md:flex space-x-8 font-semibold">
                <li><a href="{{ url('/') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition"
                        @click="open = false">Beranda</a></li>
                <li><a href="{{ route('tentang-kami') }}"
                        class="hover:text-blue-600 dark:hover:text-blue-400 transition" @click="open = false">Tentang
                        Kami</a></li>
                <li><a href="{{ route('layanan.index') }}"
                        class="hover:text-blue-600 dark:hover:text-blue-400 transition"
                        @click="open = false">Layanan</a></li>
                <li><a href="{{ route('artikel.index') }}"
                        class="hover:text-blue-600 dark:hover:text-blue-400 transition"
                        @click="open = false">Artikel</a></li>
                <li><a href="#kontak" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Kontak</a></li>
            </ul>

            {{-- Dark Mode Toggle Button --}}
            <button @click="toggleDarkMode()"
                class="ml-4 p-2 rounded bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 transition"
                :aria-label="isDark ? 'Switch to light mode' : 'Switch to dark mode'">
                <template x-if="isDark">
                    <span>☀️</span>
                </template>
                <template x-if="!isDark">
                    <span>🌙</span>
                </template>
            </button>

            {{-- Hamburger Button (Mobile) --}}
            <button class="md:hidden focus:outline-none ml-2" @click="open = !open" aria-label="Toggle menu">
                <svg class="w-6 h-6 text-gray-700 dark:text-gray-300" fill="none" stroke="currentColor"
                    stroke-width="2" viewBox="0 0 24 24">
                    <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    <path x-show="open" stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </nav>

        {{-- Menu Mobile --}}
        <div class="md:hidden px-6 pb-4 pt-2" x-show="open" x-transition>
            <ul class="flex flex-col space-y-2 font-semibold">
                <li><a href="{{ url('/') }}"
                        class="block hover:text-blue-600 dark:hover:text-blue-400 transition">Beranda</a></li>
                <li><a href="{{ route('tentang-kami') }}"
                        class="block hover:text-blue-600 dark:hover:text-blue-400 transition">Tentang Kami</a></li>
                <li><a href="{{ route('layanan.index') }}"
                        class="block hover:text-blue-600 dark:hover:text-blue-400 transition">Layanan</a></li>
                <li><a href="{{ route('artikel.index') }}"
                        class="block hover:text-blue-600 dark:hover:text-blue-400 transition">Artikel</a></li>
                <li><a href="#kontak" class="block hover:text-blue-600 dark:hover:text-blue-400 transition">Kontak</a>
                </li>
            </ul>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="bg-gray-100 text-center py-6 mt-0 text-gray-600 dark:bg-gray-800 dark:text-gray-400 text-sm">
        &copy; {{ date('Y') }} Kembar Privat Al-Quran. All rights reserved.
    </footer>

    {{-- Icon WhatsApp Mengambang --}}
    <a href="https://wa.me/081286895593" target="_blank" rel="noopener"
        class="fixed bottom-6 right-6 z-50 bg-green-500 hover:bg-green-600 transition text-white rounded-full p-4 shadow-lg"
        aria-label="Chat via WhatsApp">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
            <path
                d="M20.52 3.48A11.79 11.79 0 0012 0a11.79 11.79 0 00-8.48 3.48A11.79 11.79 0 000 12c0 2.12.55 4.17 1.59 6L0 24l6.26-1.65A11.8 11.8 0 0012 24a11.79 11.79 0 008.52-3.48A11.79 11.79 0 0024 12a11.79 11.79 0 00-3.48-8.52zM12 21.3c-1.93 0-3.79-.52-5.42-1.5l-.39-.23-3.7.97.99-3.6-.25-.37A9.43 9.43 0 012.7 12c0-5.15 4.19-9.3 9.3-9.3 2.48 0 4.8.96 6.55 2.7A9.2 9.2 0 0121.3 12c0 5.15-4.15 9.3-9.3 9.3zm5.13-6.88l-2.11-.61a.73.73 0 00-.7.18l-.9.91a7.4 7.4 0 01-3.25-3.25l.91-.9a.73.73 0 00.18-.7l-.61-2.11a.75.75 0 00-.7-.53c-.36 0-.73.03-1.1.1a1.43 1.43 0 00-1.01.98c-.14.41-.26.9-.36 1.44a6.58 6.58 0 001.6 5.41 6.58 6.58 0 005.41 1.6c.54-.1 1.03-.22 1.44-.36a1.43 1.43 0 00.98-1.01c.07-.37.1-.74.1-1.1a.75.75 0 00-.53-.7z" />
        </svg>
    </a>

    {{-- SwiperJS JS --}}
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
    <script>
        const lightbox = GLightbox({
            selector: '.glightbox'
        });
    </script>

    {{-- Alpine.js Dark Mode Toggle --}}
    <script>
        function darkModeToggle() {
            return {
                isDark: false,
                init() {
                    // cek preferensi localStorage atau system
                    this.isDark = localStorage.theme === 'dark' ||
                        (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches);

                    this.applyDarkMode();
                },
                toggleDarkMode() {
                    this.isDark = !this.isDark;
                    localStorage.theme = this.isDark ? 'dark' : 'light';
                    this.applyDarkMode();
                },
                applyDarkMode() {
                    if (this.isDark) {
                        document.documentElement.classList.add('dark');
                    } else {
                        document.documentElement.classList.remove('dark');
                    }
                }
            }
        }
    </script>

    @stack('scripts')
</body>

</html>
