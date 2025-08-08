@extends('layouts.app')

@section('title', 'Data Pelanggan')

@section('content')
    <div class="bg-white rounded-lg shadow-md p-6 min-h-[calc(100vh-160px)] flex flex-col">
        {{-- Tombol Tambah Data dan filter tanggal di pojok kanan atas kotak putih --}}
        <div class="flex justify-end mb-4 space-x-4 items-center" x-data="{ openTambahModal: false }">
            <div class="flex items-center space-x-2 text-gray-500 text-sm">
                <input type="text" readonly value="01 Jun, 2025 to 31 Jul, 2025"
                    class="bg-gray-100 rounded-md py-1 px-3 text-center cursor-pointer" />
                <button class="bg-gray-200 hover:bg-gray-300 rounded-md p-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2v-5H3v5a2 2 0 002 2z" />
                    </svg>
                </button>
            </div>
            <button @click="openTambahModal = true"
                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg flex items-center transition-colors duration-200 inline-flex">
                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Data
            </button>

            <!-- Modal Tambah Data -->
            <div x-show="openTambahModal"
                class="fixed inset-0 bg-gray-600 bg-opacity-75 flex items-center justify-center z-50 p-4" x-cloak>
                <div @click.away="openTambahModal = false"
                    class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md mx-auto relative">
                    <h3 class="text-xl font-bold mb-4 text-center">Tambah</h3>
                    <form action="#" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="file_upload" class="block text-gray-700 font-semibold mb-2">Unggah Data
                                Pelanggan</label>
                            <input type="file" id="file_upload" name="file_upload"
                                class="w-full border border-gray-300 rounded px-3 py-2" />
                            <p class="text-red-600 text-sm mt-1">*Unggah file dengan format Excel (.xls atau .xlsx)</p>
                        </div>
                        <div class="flex justify-end space-x-4">
                            <button type="button" @click="openTambahModal = false"
                                class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded transition-colors duration-200">
                                Batal
                            </button>
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition-colors duration-200">
                                Tambah
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Tabel data pelanggan --}}
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                <thead>
                    <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left">No.</th>
                        <th class="py-3 px-6 text-left">No Internet</th>
                        <th class="py-3 px-6 text-left">No Digital</th>
                        <th class="py-3 px-6 text-left">Tanggal PS</th>
                        <th class="py-3 px-6 text-left">Datel</th>
                        <th class="py-3 px-6 text-left">STO</th>
                        <th class="py-3 px-6 text-left">Nama</th>
                        <th class="py-3 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light" x-data="{ openPreviewModal: false }">
                    @foreach ($pelanggan as $item)
                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                            <td class="py-3 px-6 text-left whitespace-nowrap">{{ $item['id'] }}.</td>
                            <td class="py-3 px-6 text-left">{{ $item['no_internet'] }}</td>
                            <td class="py-3 px-6 text-left">{{ $item['no_digital'] }}</td>
                            <td class="py-3 px-6 text-left">{{ $item['tanggal_ps'] }}</td>
                            <td class="py-3 px-6 text-left">{{ $item['datel'] }}</td>
                            <td class="py-3 px-6 text-left">{{ $item['sto'] }}</td>
                            <td class="py-3 px-6 text-left font-semibold">{{ $item['nama'] }}</td>
                            <td class="py-3 px-6 text-center">
                                <div class="flex item-center justify-center space-x-2">
                                    <a href="{{ route('pelanggan.show', ['id' => $item['id']]) }}"
                                        class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-1 px-3 rounded text-xs transition-colors duration-200 inline-block text-center">Lihat</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

                {{-- Modal Preview Detail Data --}}
                <div x-show="openPreviewModal"
                    class="fixed inset-0 bg-gray-600 bg-opacity-75 flex items-center justify-center z-50 p-4" x-cloak>
                    <div @click.away="openPreviewModal = false"
                        class="bg-white rounded-lg shadow-xl p-6 w-full max-w-lg mx-auto relative">
                        <button @click="openPreviewModal = false"
                            class="absolute top-3 right-3 text-gray-600 hover:text-gray-900">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                        <h3 class="text-xl font-bold mb-4 text-center">Detail Data</h3>
                        <div class="overflow-y-auto max-h-[60vh]">
                            <table class="w-full text-sm text-left text-gray-700">
                                <tbody>
                            </table>
                        </div>
                        <div class="flex justify-end space-x-4 mt-4">
                            {{-- Tombol Edit dan Hapus dihapus sesuai permintaan user --}}
                        </div>
                    </div>
                </div>
            </table>
        </div>

        {{-- Baris per halaman --}}
        <div class="flex justify-end mt-4 text-sm text-gray-600">
            Baris per halaman 7
        </div>

        {{-- Hapus detail data pelanggan di bawah tabel utama --}}
        {{-- Bagian detail data pelanggan dihapus sesuai permintaan user --}}

@endsection