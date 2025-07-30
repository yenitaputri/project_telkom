@extends('layouts.app')

@section('title', 'Data Sales')

@section('content')
    {{-- Main content area --}}
    <div class="bg-white rounded-lg shadow-md p-6 min-h-[calc(100vh-160px)] flex flex-col">
        {{-- Tombol Tambah Data di pojok kanan atas kotak putih --}}
        <div class="flex justify-end mb-4">
            <button class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg flex items-center transition-colors duration-200">
                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Data
            </button>
        </div>

        {{-- Area untuk pesan "Tidak ditemukan data" atau tabel data --}}
        <div class="flex-1 flex flex-col items-center justify-center p-4">
            <p class="text-gray-500 text-lg text-center">Tidak ditemukan data. Mohon unggah file terlebih dahulu atau buat file baru untuk memulai.</p>
        </div>
    </div>
@endsection