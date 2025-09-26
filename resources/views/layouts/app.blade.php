<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Indibiz - @yield('title', 'Admin Panel')</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />

    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="bg-[#E0F2F1] font-sans antialiased">
    <div class="flex h-screen overflow-hidden" x-data="{ sidebarOpen: false }">

        <div x-show="sidebarOpen" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" @click="sidebarOpen = false"
            class="fixed inset-0 z-10 bg-black bg-opacity-50 lg:hidden">
        </div>

        <aside class="fixed inset-y-0 left-0 w-64 bg-white shadow-lg transform transition-transform duration-300 ease-in-out z-20 flex flex-col lg:relative lg:translate-x-0
            -translate-x-full" :class="{'translate-x-0': sidebarOpen }">

            {{-- Bagian atas sidebar: Logo --}}
            <div class="pt-2 pb-6 flex items-center justify-start border-b border-gray-200 h-23 overflow-hidden">
                <img src="{{ asset('images/logosales2.png') }}" alt="Logo Sales" class="h-20 w-auto object-contain">
            </div>



            {{-- Bagian tengah sidebar: Navigasi --}}
            <nav class="mt-8 flex-1 overflow-y-auto">
                <ul class="space-y-2">
                    <li>
                        {{-- BERANDA --}}
                        <a href="{{ route('home.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-teal-50 hover:text-teal-600 rounded-lg mx-3 transition-colors duration-200
                            {{ request()->routeIs('home.index') ? 'bg-blue-600 text-white font-semibold' : '' }}"> {{--
                            DIUBAH DI SINI --}}
                            <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 001 1h3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                </path>
                            </svg>
                            Beranda
                        </a>
                    </li>
                    <li>
                        {{-- DATA SALES --}}
                        <a href="{{ route('sales.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-teal-50 hover:text-teal-600 rounded-lg mx-3 transition-colors duration-200
                            {{ request()->routeIs('sales.index') ? 'bg-blue-600 text-white font-semibold' : '' }}">
                            {{-- DIUBAH DI SINI --}}
                            <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                </path>
                            </svg>
                            Data Sales
                        </a>
                    </li>
                    <li>
                        {{-- DATA PELANGGAN --}}
                        <a href="{{ route('pelanggan.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-teal-50 hover:text-teal-600 rounded-lg mx-3 transition-colors duration-200
                            {{ request()->routeIs('pelanggan.index') ? 'bg-blue-600 text-white font-semibold' : '' }}">
                            {{-- DIUBAH DI SINI --}}
                            <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H2v-2a3 3 0 015.356-1.857M17 20v-9a2 2 0 00-2-2H9a2 2 0 00-2 2v9m-2 7h10a2 2 0 002-2v-9a2 2 0 00-2-2h-2m-2-6a3 3 0 11-6 0 3 3 0 016 0zm-2 10H5a2 2 0 00-2 2v2">
                                </path>
                            </svg>
                            Data Pelanggan
                        </a>
                    </li>
                    <li>
                        {{-- DATA PRODIGI --}}
                        <a href="{{ route('prodigi.index') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-teal-50 hover:text-teal-600 rounded-lg mx-3 transition-colors duration-200
                            {{ request()->routeIs('prodigi.index') ? 'bg-blue-600 text-white font-semibold' : '' }}">
                            {{-- DIUBAH DI SINI --}}
                            <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16m-7 6h7"></path>
                            </svg>
                            Data Prodigi
                        </a>
                    </li>
                </ul>
            </nav>

            {{-- Tombol Logout (gunakan form POST) --}}
            <div class="p-6">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center px-6 py-3 text-gray-600 hover:bg-red-50 hover:text-red-600 rounded-lg mx-3 transition-colors duration-200">
                        <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                            </path>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>



        </aside>
        <div class="flex flex-col flex-1 overflow-y-auto">
            <header class="bg-white shadow-sm p-4 flex items-center justify-between">
                <div class="flex items-center">
                    <button @click="sidebarOpen = ! sidebarOpen"
                        class="p-2 text-gray-500 hover:text-gray-700 focus:outline-none focus:text-gray-700 mr-4 transition-colors duration-200">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    <h1 class="text-2xl font-semibold text-gray-800">Admin</h1>
                </div>
                <div class="relative">
                    @if (! request()->routeIs('pelanggan.show'))
                        <!-- <form action="{{ route('search') }}" method="get">
                                                                                                        <div class="relative w-full max-w-xs">
                                                                                                            <input type="text" name="q" placeholder="Cari di sini..."
                                                                                                                class="w-full py-2 px-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent pr-10">
                                                                                                            <button type="submit"
                                                                                                                class="absolute top-0 bottom-0 right-4 text-gray-500 hover:text-gray-700 transition-colors duration-200">
                                                                                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                                                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z">
                                                                                                                    </path>
                                                                                                                </svg>
                                                                                                            </button>
                                                                                                        </div>
                                                                                                    </form> -->
                    @else
                        <div class="flex items-center space-x-2 h-full text-sm">
                            <span class="text-black font-semibold">Data Pelanggan</span>
                            <span class="inline-block w-2 h-2 bg-blue-600 rounded-full mx-1"></span>
                            <span class="text-blue-600 font-semibold">Lihat</span>
                        </div>
                    @endif
                </div>
            </header>
            <main class="flex-1 p-6">
                @yield('content')
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.46.0/dist/apexcharts.min.js"></script>
    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}',
                timer: 2000,
                showConfirmButton: false
            });
        </script>
    @endif
    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Yakin hapus data ini?',
                text: "Data yang dihapus tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
    @stack('scripts')
</body>

</html>