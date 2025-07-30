@extends('layouts.app')

@section('title', 'Data Sales')

@section('content')
    {{-- Main content area dengan Alpine.js untuk modal --}}
    <div class="bg-white rounded-lg shadow-md p-6 min-h-[calc(100vh-160px)] flex flex-col" x-data="{ openModal: false }">

        {{-- Tombol Tambah Data di pojok kanan atas kotak putih --}}
        <div class="flex justify-end mb-4">
            <button @click="openModal = true" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg flex items-center transition-colors duration-200">
                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Data
            </button>
        </div>

        {{-- BAGIAN TABEL DATA SALES (Tampilan Awal) --}}
        @php
            // Ini adalah data dummy. Di aplikasi nyata, Anda akan mendapatkan ini dari controller:
            // $sales = \App\Models\Sales::all(); atau dari $sales yang dilewatkan dari controller
            $sales = [
                ['no' => 1, 'gambar' => asset('images/default_sales_avatar.png'), 'kode' => 'MC30218', 'nama' => 'RADITYA ARYA PRAMANA', 'agency' => 'BLM'],
                ['no' => 2, 'gambar' => asset('images/default_sales_avatar.png'), 'kode' => 'MC30219', 'nama' => 'BIMA SATRIA', 'agency' => 'ABC'],
                ['no' => 3, 'gambar' => asset('images/default_sales_avatar.png'), 'kode' => 'MC30220', 'nama' => 'CINTA ANGGRAINI', 'agency' => 'XYZ'],
                // Tambahkan lebih banyak data dummy jika diperlukan
            ];
            $hasSalesData = count($sales) > 0;
        @endphp

        @if ($hasSalesData)
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                    <thead>
                        <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">No.</th>
                            <th class="py-3 px-6 text-left">Gambar Sales</th>
                            <th class="py-3 px-6 text-left">Kode Sales</th>
                            <th class="py-3 px-6 text-left">Nama Sales</th>
                            <th class="py-3 px-6 text-left">Agency</th>
                            <th class="py-3 px-6 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                        @foreach ($sales as $sale)
                            <tr class="border-b border-gray-200 hover:bg-gray-50">
                                <td class="py-3 px-6 text-left whitespace-nowrap">{{ $sale['no'] }}</td>
                                <td class="py-3 px-6 text-left">
                                    <img src="{{ $sale['gambar'] }}" alt="Gambar Sales" class="w-10 h-10 rounded-full object-cover">
                                </td>
                                <td class="py-3 px-6 text-left">{{ $sale['kode'] }}</td>
                                <td class="py-3 px-6 text-left">{{ $sale['nama'] }}</td>
                                <td class="py-3 px-6 text-left">{{ $sale['agency'] }}</td>
                                <td class="py-3 px-6 text-center">
                                    <div class="flex item-center justify-center space-x-2">
                                        {{-- Tombol Lihat --}}
                                        <button class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-1 px-3 rounded text-xs transition-colors duration-200">Lihat</button>
                                        {{-- Tombol Edit --}}
                                        <button class="bg-green-500 hover:bg-green-600 text-white font-bold py-1 px-3 rounded text-xs transition-colors duration-200">Edit</button>
                                        {{-- Tombol Hapus --}}
                                        <button class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded text-xs transition-colors duration-200">Hapus</button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Baris per halaman (seperti di gambar) --}}
            <div class="flex justify-end mt-4 text-sm text-gray-600">
                Baris per halaman 7
            </div>
        @else
            {{-- Pesan "Tidak ditemukan data" jika tidak ada data sales --}}
            <div class="flex-1 flex flex-col items-center justify-center p-4">
                <p class="text-gray-500 text-lg text-center">Tidak ditemukan data. Mohon unggah file terlebih dahulu atau buat file baru untuk memulai.</p>
            </div>
        @endif


        {{-- BAGIAN MODAL (POP-UP) TAMBAH DATA SALES --}}
        <div x-show="openModal" class="fixed inset-0 bg-gray-600 bg-opacity-75 flex items-center justify-center z-50 p-4" x-cloak>
            <div @click.away="openModal = false" class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md mx-auto">
                <h3 class="text-2xl font-bold text-gray-800 mb-6 text-center">Tambah</h3>

                <form action="#" method="POST" enctype="multipart/form-data"> {{-- Ganti action="#" dengan route yang sesuai --}}
                    @csrf
                    <div class="mb-4 text-center">
                        {{-- Placeholder Gambar Sales --}}
                        <div class="w-24 h-24 bg-gray-200 rounded-full mx-auto flex items-center justify-center text-gray-400 mb-2">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <input type="file" id="gambar_sales" name="gambar_sales" class="hidden">
                        <label for="gambar_sales" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-2 px-4 rounded inline-flex items-center cursor-pointer">
                            <span>Choose File</span>
                        </label>
                        <span id="file-name" class="ml-2 text-gray-600">No file chosen</span>
                    </div>

                    <div class="mb-4">
                        <label for="kode_sales" class="block text-gray-700 text-sm font-bold mb-2">Kode Sales</label>
                        <input type="text" id="kode_sales" name="kode_sales" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Masukkan Kode Sales">
                    </div>

                    <div class="mb-4">
                        <label for="nama_sales" class="block text-gray-700 text-sm font-bold mb-2">Nama Sales</label>
                        <input type="text" id="nama_sales" name="nama_sales" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Masukkan Nama Sales">
                    </div>

                    <div class="mb-6">
                        <label for="agency" class="block text-gray-700 text-sm font-bold mb-2">Agency</label>
                        <input type="text" id="agency" name="agency" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Masukkan Agency">
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

    </div>

    {{-- Script untuk menampilkan nama file yang dipilih --}}
    <script>
        document.getElementById('gambar_sales').addEventListener('change', function() {
            var fileName = this.files[0] ? this.files[0].name : 'No file chosen';
            document.getElementById('file-name').textContent = fileName;
        });
    </script>
@endsection