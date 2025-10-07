@extends('layouts.app')

@section('title', 'Tambah Data Astinet')

@section('content')
<div class="bg-white rounded-lg shadow p-6 max-w-2xl mx-auto min-h-[calc(100vh-160px)]">

    <h2 class="text-xl font-semibold mb-4">Tambah Data Astinet</h2>

    {{-- Form Tambah --}}
    <form action="{{ route('astinet.store') }}" method="POST">
        @csrf

        {{-- Kode Order --}}
        <div class="mb-4">
            <label for="kode_order" class="block text-gray-700 font-medium mb-1">Kode Order</label>
            <input type="text" name="kode_order" id="kode_order" value="{{ old('kode_order') }}"
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            @error('kode_order')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- SID --}}
        <div class="mb-4">
            <label for="sid" class="block text-gray-700 font-medium mb-1">SID</label>
            <input type="text" name="sid" id="sid" value="{{ old('sid') }}"
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            @error('sid')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Bandwidth --}}
        <div class="mb-4">
            <label for="bandwidth" class="block text-gray-700 font-medium mb-1">Besar Bandwidth</label>
            <input type="text" name="bandwidth" id="bandwidth" value="{{ old('bandwidth') }}"
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            @error('bandwidth')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Nama Pelanggan --}}
        <div class="mb-4">
            <label for="nama_pelanggan" class="block text-gray-700 font-medium mb-1">Nama Pelanggan</label>
            <input type="text" name="nama_pelanggan" id="nama_pelanggan" value="{{ old('nama_pelanggan') }}"
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            @error('nama_pelanggan')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Nama Sales --}}
        <div class="mb-4">
            <label for="nama_sales" class="block text-gray-700 font-medium mb-1">Nama Sales</label>
            <input type="text" name="nama_sales" id="nama_sales" value="{{ old('nama_sales') }}"
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            @error('nama_sales')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Tanggal Complete --}}
        <div class="mb-4">
            <label for="tanggal_complete" class="block text-gray-700 font-medium mb-1">Tanggal Complete</label>
            <input type="date" name="tanggal_complete" id="tanggal_complete" value="{{ old('tanggal_complete') }}"
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            @error('tanggal_complete')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Tombol Submit --}}
        <div class="flex justify-end">
            <a href="{{ route('astinet.index') }}" class="mr-2 px-4 py-2 rounded bg-gray-300 hover:bg-gray-400 text-gray-700 transition">Batal</a>
            <button type="submit" class="px-4 py-2 rounded bg-blue-600 hover:bg-blue-700 text-white transition">Simpan</button>
        </div>
    </form>

</div>
@endsection
