@extends('layouts.app')

@section('title', 'Data Pelanggan')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6 min-h-[calc(100vh-160px)] flex flex-col" x-data="{ openModal: false }">
    {{-- Tombol Tambah Data dan filter tanggal di pojok kanan atas kotak putih --}}
    <div class="flex justify-end mb-4 space-x-4 items-center">
        <div class="flex items-center space-x-2 text-gray-500 text-sm">
            <input type="text" readonly value="01 Jun, 2025 to 31 Jul, 2025" class="bg-gray-100 rounded-md py-1 px-3 text-center cursor-pointer" />
            <button class="bg-gray-200 hover:bg-gray-300 rounded-md p-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2v-5H3v5a2 2 0 002 2z" />
                </svg>
            </button>
        </div>
        <a href="{{ route('pelanggan.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg flex items-center transition-colors duration-200 inline-flex">
            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Data
        </a>
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
        @foreach (range(1,7) as $i)
        <tr class="border-b border-gray-200 hover:bg-gray-50">
            <td class="py-3 px-6 text-left whitespace-nowrap">{{ $i }}.</td>
            <td class="py-3 px-6 text-left">152516209310</td>
            <td class="py-3 px-6 text-left">152516209310</td>
            <td class="py-3 px-6 text-left">05/07/2025</td>
            <td class="py-3 px-6 text-left">BNYWANGI</td>
            <td class="py-3 px-6 text-left">RGJ</td>
            <td class="py-3 px-6 text-left font-semibold">HERO GYM</td>
            <td class="py-3 px-6 text-center">
                <div class="flex item-center justify-center space-x-2">
                    <a href="{{ route('pelanggan.show', ['id' => $i]) }}" class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-1 px-3 rounded text-xs transition-colors duration-200 inline-block text-center">Lihat</a>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>

    {{-- Modal Preview Detail Data --}}
    <div x-show="openPreviewModal" class="fixed inset-0 bg-gray-600 bg-opacity-75 flex items-center justify-center z-50 p-4" x-cloak>
        <div @click.away="openPreviewModal = false" class="bg-white rounded-lg shadow-xl p-6 w-full max-w-lg mx-auto relative">
            <button @click="openPreviewModal = false" class="absolute top-3 right-3 text-gray-600 hover:text-gray-900">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <h3 class="text-xl font-bold mb-4 text-center">Detail Data</h3>
            <div class="overflow-y-auto max-h-[60vh]">
                <table class="w-full text-sm text-left text-gray-700">
                    <tbody>
                        <tr><th class="py-1 px-2 font-semibold border-b">No Internet</th><td class="py-1 px-2 border-b">152516209310</td></tr>
                        <tr><th class="py-1 px-2 font-semibold border-b">No Digital</th><td class="py-1 px-2 border-b">152516209310</td></tr>
                        <tr><th class="py-1 px-2 font-semibold border-b">Tanggal PS</th><td class="py-1 px-2 border-b">08/07/2023</td></tr>
                        <tr><th class="py-1 px-2 font-semibold border-b">Kecapatan</th><td class="py-1 px-2 border-b">200</td></tr>
                        <tr><th class="py-1 px-2 font-semibold border-b">Bulan</th><td class="py-1 px-2 border-b">7</td></tr>
                        <tr><th class="py-1 px-2 font-semibold border-b">Tahun</th><td class="py-1 px-2 border-b">2025</td></tr>
                        <tr><th class="py-1 px-2 font-semibold border-b">Datel</th><td class="py-1 px-2 border-b">BNYWANGI</td></tr>
                        <tr><th class="py-1 px-2 font-semibold border-b">RO</th><td class="py-1 px-2 border-b"></td></tr>
                        <tr><th class="py-1 px-2 font-semibold border-b">STO</th><td class="py-1 px-2 border-b">RGJ</td></tr>
                        <tr><th class="py-1 px-2 font-semibold border-b">Nama</th><td class="py-1 px-2 border-b">Toko Rofi / MOH ROFIUDIN</td></tr>
                        <tr><th class="py-1 px-2 font-semibold border-b">Segmen</th><td class="py-1 px-2 border-b">DBS-Commerce & Community Serv</td></tr>
                        <tr><th class="py-1 px-2 font-semibold border-b">Kcontact</th><td class="py-1 px-2 border-b">DS/05/JR/DS50205/MUHLAS/DIGIBIZ 75MBPS/PIC 81217766672</td></tr>
                        <tr><th class="py-1 px-2 font-semibold border-b">Jenis Layanan</th><td class="py-1 px-2 border-b">INDIBIZ</td></tr>
                        <tr><th class="py-1 px-2 font-semibold border-b">Channel 1</th><td class="py-1 px-2 border-b">Sales Force DBS</td></tr>
                        <tr><th class="py-1 px-2 font-semibold border-b">Cek Netmonk</th><td class="py-1 px-2 border-b"></td></tr>
                        <tr><th class="py-1 px-2 font-semibold border-b">Cek Pijar Mahir</th><td class="py-1 px-2 border-b"></td></tr>
                        <tr><th class="py-1 px-2 font-semibold border-b">Cek Eazy Cam</th><td class="py-1 px-2 border-b"></td></tr>
                        <tr><th class="py-1 px-2 font-semibold border-b">Cek Oca</th><td class="py-1 px-2 border-b"></td></tr>
                        <tr><th class="py-1 px-2 font-semibold border-b">Cek Pijar Sekolah</th><td class="py-1 px-2 border-b"></td></tr>
                        <tr><th class="py-1 px-2 font-semibold border-b">Kode Sales</th><td class="py-1 px-2 border-b">DS50216</td></tr>
                        <tr><th class="py-1 px-2 font-semibold border-b">Nama SF</th><td class="py-1 px-2 border-b">RYZAL RYAN (BLM)</td></tr>
                        <tr><th class="py-1 px-2 font-semibold border-b">Agency</th><td class="py-1 px-2 border-b">MCA</td></tr>
                    </tbody>
                </table>
            </div>
            <div class="flex justify-end space-x-4 mt-4">
                <button class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded transition-colors duration-200">Edit</button>
                <button class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded transition-colors duration-200">Hapus</button>
            </div>
        </div>
    </div>
        </table>
    </div>

    {{-- Baris per halaman --}}
    <div class="flex justify-end mt-4 text-sm text-gray-600">
        Baris per halaman 7
    </div>

    {{-- Modal Tambah Data (kosong, hanya tampilan) --}}
    <div x-show="openModal" class="fixed inset-0 bg-gray-600 bg-opacity-75 flex items-center justify-center z-50 p-4" x-cloak>
        <div @click.away="openModal = false" class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md mx-auto">
            <h3 class="text-2xl font-bold text-gray-800 mb-6 text-center">Tambah</h3>

            <form action="#" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4 text-center">
                    <div class="w-24 h-24 bg-gray-200 rounded-full mx-auto flex items-center justify-center text-gray-400 mb-2">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <input type="file" id="gambar_pelanggan" name="gambar_pelanggan" class="hidden">
                    <label for="gambar_pelanggan" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-2 px-4 rounded inline-flex items-center cursor-pointer">
                        <span>Choose File</span>
                    </label>
                    <span id="file-name" class="ml-2 text-gray-600">No file chosen</span>
                </div>

                <div class="mb-4">
                    <label for="no_internet" class="block text-gray-700 text-sm font-bold mb-2">No Internet</label>
                    <input type="text" id="no_internet" name="no_internet" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Masukkan No Internet">
                </div>

                <div class="mb-4">
                    <label for="no_digital" class="block text-gray-700 text-sm font-bold mb-2">No Digital</label>
                    <input type="text" id="no_digital" name="no_digital" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Masukkan No Digital">
                </div>

                <div class="mb-4">
                    <label for="tanggal_ps" class="block text-gray-700 text-sm font-bold mb-2">Tanggal PS</label>
                    <input type="date" id="tanggal_ps" name="tanggal_ps" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <div class="mb-4">
                    <label for="datel" class="block text-gray-700 text-sm font-bold mb-2">Datel</label>
                    <input type="text" id="datel" name="datel" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Masukkan Datel">
                </div>

                <div class="mb-4">
                    <label for="sto" class="block text-gray-700 text-sm font-bold mb-2">STO</label>
                    <input type="text" id="sto" name="sto" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Masukkan STO">
                </div>

                <div class="mb-6">
                    <label for="nama" class="block text-gray-700 text-sm font-bold mb-2">Nama</label>
                    <input type="text" id="nama" name="nama" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Masukkan Nama">
                </div>

                <div class="flex justify-end space-x-4">
                    <button type="button" @click="openModal = false" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded transition-colors duration-200">
                        Batal
                    </button>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition-colors duration-200">
                        Tambah
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Script untuk menampilkan nama file yang dipilih --}}
    <script>
        document.getElementById('gambar_pelanggan').addEventListener('change', function() {
            var fileName = this.files[0] ? this.files[0].name : 'No file chosen';
            document.getElementById('file-name').textContent = fileName;
        });
    </script>
</div>
@endsection
