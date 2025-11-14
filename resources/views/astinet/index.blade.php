@extends('layouts.app')

@section('title', 'Data Astinet')

@section('content')

    <div class="bg-white rounded-lg shadow p-4 min-h-[calc(100vh-160px)] flex flex-col">

        {{-- Tombol Tambah dan Pencarian --}}
        <div class="flex justify-end mb-4">
            <form action="{{ route('astinet.index') }}" method="get" class="mr-auto">
                <div class="relative w-full max-w-xs">
                    <input type="text" name="q" placeholder="Cari di sini..."
                        class="w-full py-2 px-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent pr-10">
                    <button type="submit"
                        class="absolute top-0 bottom-0 right-4 text-gray-500 hover:text-gray-700 transition-colors duration-200">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                </div>
            </form>

            {{-- Tombol Tambah Data --}}
            <a href="{{ route('astinet.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded flex items-center text-sm transition-colors">
                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Data
            </a>
        </div>

        {{-- Pesan Hasil Pencarian --}}
        @if(request('q'))
            <p class="mb-4 text-sm text-gray-600">
                Hasil pencarian untuk: <span class="font-semibold">"{{ request('q') }}"</span>
                <a href="{{ route('astinet.index') }}" class="text-blue-500 hover:underline ml-2">Reset</a>
            </p>
        @endif

        {{-- Tabel Astinet --}}
        @if ($astinets->count())
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto bg-white border border-gray-200 rounded text-sm">
                    <thead class="bg-blue-100 text-gray-700">
                        <tr>
                            <th class="border px-2 py-2 font-bold text-left align-middle">No</th>
                            <th class="border px-2 py-2 font-bold text-left align-middle">Kode Order</th>
                            <th class="border px-2 py-2 font-bold text-left align-middle">SID</th>
                            <th class="border px-2 py-2 font-bold text-left align-middle">Besar Bandwidth</th>
                            <th class="border px-2 py-2 font-bold text-left align-middle">Nama Pelanggan</th>
                            <th class="border px-2 py-2 font-bold text-left align-middle">Nama Sales</th>
                            <th class="border px-2 py-2 font-bold text-left align-middle">Tanggal Complete</th>
                            <th class="border px-2 py-2 font-bold text-center align-middle">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600">
                        @foreach ($astinets as $index => $astinet)
                            <tr class="border-t hover:bg-gray-100 transition">
                                <td class="px-2 py-2 text-left align-middle">{{ $loop->iteration }}</td>
                                <td class="px-2 py-2 text-left align-middle">{{ $astinet->kode_order }}</td>
                                <td class="px-2 py-2 text-left align-middle">{{ $astinet->sid }}</td>
                                <td class="px-2 py-2 text-left align-middle">{{ $astinet->bandwidth }}</td>
                                <td class="px-2 py-2 text-left align-middle">{{ $astinet->nama_pelanggan }}</td>
                                <td class="px-2 py-2 text-left align-middle">{{ $astinet->sales->nama_sales }}</td>
                                <td class="px-2 py-2 text-left align-middle">
                                    {{ \Carbon\Carbon::parse($astinet->tanggal_complete)->format('d-m-Y') }}
                                </td>
                                {{-- Di bagian tbody, ganti tombol hapus dengan form dan button --}}
                                <td class="px-2 py-2 text-center align-middle space-x-1">
                                    {{-- Tombol Edit --}}
                                    <a href="{{ route('astinet.edit', $astinet->id) }}"
                                        class="bg-green-500 hover:bg-green-600 text-white px-2 py-1 rounded text-xs transition-colors">
                                        Edit
                                    </a>

                                    {{-- Tombol Hapus --}}
                                    <form action="{{ route('astinet.destroy', $astinet->id) }}" method="POST" class="inline-block"
                                        id="delete-form-{{ $astinet->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                            class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-xs transition-colors"
                                            onclick="confirmDelete({{ $astinet->id }})">
                                            Hapus
                                        </button>
                                    </form>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Pagination dan per page --}}
                <div class="flex flex-col sm:flex-row justify-between items-center mt-4 px-2 gap-y-2">
                    <form method="GET" action="{{ route('astinet.index') }}" class="flex items-center space-x-2">
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

                    <div
                        class="flex flex-col sm:flex-row sm:items-center sm:space-x-4 w-full sm:w-auto justify-between sm:justify-end">
                        <div>
                            {{ $astinets->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center text-gray-500 mt-8">
                Tidak ditemukan data Astinet.
            </div>
        @endif

    </div>

@endsection