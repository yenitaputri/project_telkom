@extends('layouts.app')

@section('title', 'Data Prodigi')

@section('content')
    <div x-data="{ openTambahModal: false }"
        class="bg-white rounded-lg shadow-md p-6 min-h-[calc(100vh-160px)] flex flex-col">
        {{-- Tombol Tambah Data dan filter tanggal --}}
        <div class="flex justify-end mb-4 space-x-4 items-center">

            <form action="{{ route('prodigi.index') }}" method="get" class="mr-auto">
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
            </form>

            <form id="date-form" method="GET" action="{{ route('prodigi.index') }}">
                <div class="flex items-center space-x-2 text-gray-500 text-sm">
                    <div id="date-range-picker" date-rangepicker class="flex items-center">
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                </svg>
                            </div>
                            <input id="datepicker-range-start" name="start" type="text"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Mulai tanggal">
                        </div>
                        <span class="mx-4 text-gray-500">to</span>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                </svg>
                            </div>
                            <input id="datepicker-range-end" name="end" type="text"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Sampai tanggal">
                        </div>
                    </div>
                    <button class="bg-gray-200 hover:bg-gray-300 rounded-md p-1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                        </svg>
                    </button>
                </div>
            </form>

            <button @click="openTambahModal = true"
                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg flex items-center transition-colors duration-200 inline-flex">
                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Data
            </button>
        </div>

        <!-- Modal Tambah Data -->
        <div x-show="openTambahModal"
            class="fixed inset-0 bg-gray-600 bg-opacity-75 flex items-center justify-center z-50 p-4" x-cloak>
            <div @click.away="openTambahModal = false"
                class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md mx-auto relative">
                <h3 class="text-xl font-bold mb-4 text-center">Tambah Data Prodigi</h3>
                <form action="{{ route('prodigi.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label for="file_upload" class="block text-gray-700 font-semibold mb-2">
                            Unggah Data Pelanggan
                        </label>
                        <input type="file" id="file_upload" name="file_upload" accept=".xls,.xlsx"
                            class="w-full border border-gray-300 rounded px-3 @error('file_upload') border-red-500 @enderror" />
                        <p class="text-red-600 text-sm mt-1">
                            *Unggah file dengan format Excel (.xls atau .xlsx)
                        </p>
                        @error('file_upload')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex justify-end space-x-4">
                        <button type="button" @click="openTambahModal = false"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded transition-colors duration-200">
                            Batal
                        </button>
                        <button type="submit"
                            class=" bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition-colors duration-200">
                            Tambah
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Tabel data prodigi --}}
        <div class="overflow-x-auto">
            @if(request('q') || (request('start') && request('end')))
                <p class="mb-4 text-sm text-gray-600">
                    Hasil pencarian untuk:
                    @if(request('q'))
                        <span class="font-semibold">"{{ request('q') }}"</span>
                    @endif
                    @if(request('start') && request('end'))
                        dari <span class="font-semibold">{{ request('start') }}</span>
                        sampai <span class="font-semibold">{{ request('end') }}</span>
                    @endif
                    <a href="{{ route('prodigi.index') }}" class="text-blue-500 hover:underline ml-2">Reset</a>
                </p>
            @endif
            <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                <thead>
                    <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left">No.</th>
                        <th class="py-3 px-6 text-left">Order_ID</th>
                        <th class="py-3 px-6 text-left">ND</th>
                        <th class="py-3 px-6 text-left">Customer Name</th>
                        <th class="py-3 px-6 text-left">Witel</th>
                        <th class="py-3 px-6 text-left">Telda</th>
                        <th class="py-3 px-6 text-left">Paket</th>
                        <th class="py-3 px-6 text-left">Tanggal_PS</th>
                        <th class="py-3 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    @forelse($prodigi as $item)
                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                            <td class="py-3 px-6 text-left whitespace-nowrap">{{ $item->id }}.</td>
                            <td class="py-3 px-6 text-left">{{ $item->order_id }}</td>
                            <td class="py-3 px-6 text-left">{{ $item->nd }}</td>
                            <td class="py-3 px-6 text-left">{{ $item->customer_name }}</td>
                            <td class="py-3 px-6 text-left">{{ $item->witel }}</td>
                            <td class="py-3 px-6 text-left">{{ $item->telda }}</td>
                            <td class="py-3 px-6 text-left">{{ $item->paket }}</td>
                            <td class="py-3 px-6 text-left">
                                {{ \Carbon\Carbon::parse($item->tanggal_ps)->format('m/d/Y') }}
                            </td>
                            <td class="py-3 px-6 text-center">
                                <div class="flex item-center justify-center space-x-2">
                                    <a href="{{ route('prodigi.show', ['id' => $item['id']]) }}"
                                        class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-1 px-3 rounded text-xs transition-colors duration-200 inline-block text-center">Lihat</a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-3 text-gray-500">
                                Tidak ditemukan data. Mohon unggah file
                                terlebih dahulu atau buat file baru untuk memulai.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Baris per halaman --}}
        <div class="flex justify-start mt-4 text-sm text-gray-600">
            <form method="GET" action="{{ route('prodigi.index') }}" class="flex items-center space-x-2">
                <label for="per_page" class="text-sm text-gray-700">Baris per halaman:</label>
                <select name="per_page" id="per_page" onchange="this.form.submit()"
                    class="border-gray-300 rounded-md text-sm py-1">
                    @foreach([5, 10, 25, 50, 100] as $limit)
                        <option value="{{ $limit }}" {{ request('per_page', 10) == $limit ? 'selected' : '' }}>
                            {{ $limit }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>

        <!-- Navigasi Pagination -->
        <div class="mt-4">
            {{ $prodigi->appends(['start' => request('start'), 'end' => request('end')])->links() }}
        </div>

    </div>
    <script>
        // Script untuk form tetap, tetapi tidak akan memengaruhi rute
        document.getElementById('date-form').addEventListener('submit', function (e) {
            e.preventDefault(); // Mencegah form dikirim
            const startEl = document.getElementById('datepicker-range-start');
            const endEl = document.getElementById('datepicker-range-end');

            function formatToYMD(dateStr) {
                const d = new Date(dateStr);
                if (isNaN(d)) return ''; // kalau tidak valid
                let month = (d.getMonth() + 1).toString().padStart(2, '0');
                let day = d.getDate().toString().padStart(2, '0');
                return `${d.getFullYear()}-${month}-${day}`;
            }

            // Ini hanya untuk tampilan di konsol, tidak akan memengaruhi data
            console.log('Start Date:', formatToYMD(startEl.value));
            console.log('End Date:', formatToYMD(endEl.value));
        });
    </script>
@endsection