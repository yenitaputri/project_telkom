@extends('layouts.app')

@section('content')
    <div class="bg-white border border-blue-400 rounded-md p-6 h-96 flex flex-col justify-between">
        <div class="text-center text-gray-500 text-sm mt-10">
            Tidak ditemukan data. Mohon unggah file terlebih dahulu atau buat file baru untuk memulai.
        </div>

        <div class="flex justify-end">
            <a href="/data-sales/create" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-semibold">
                + Tambah Data
            </a>
        </div>
    </div>
@endsection
