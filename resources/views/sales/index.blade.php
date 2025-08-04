@extends('layouts.app')

@section('title', 'Data Sales')

@section('content')
<div class="bg-white rounded-lg shadow p-4 min-h-[calc(100vh-160px)] flex flex-col" 
    x-data="{ 
        openAddModal: {{ $errors->any() ? 'true' : 'false' }},
        openDeleteModal: false, 
        deleteUrl: '' 
    }">

    {{-- Tombol Tambah --}}
    <div class="flex justify-end mb-4">
        <button @click="openAddModal = true"
            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded flex items-center text-sm transition-colors">
            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah Data
        </button>
    </div>

    {{-- Alert Sukses --}}
@if (session('success'))
    <div 
        x-data="{ show: true }" 
        x-init="setTimeout(() => show = false, 3000)" 
        x-show="show"
        x-transition
        class="flex items-center p-4 mb-4 text-sm text-green-800 bg-green-100 border border-green-300 rounded-lg"
        role="alert"
    >
        <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M5 13l4 4L19 7" />
        </svg>
        <span>{{ session('success') }}</span>
    </div>
@endif

    {{-- Tabel Sales --}}
    @if ($sales->count())
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto bg-white border border-gray-200 rounded text-sm">
            <thead class="bg-blue-100 text-gray-700">
                <tr>
                    <th class="border px-4 py-2 font-bold text-left align-middle">No</th>
                    <th class="border px-4 py-2 font-bold text-left align-middle">Gambar</th>
                    <th class="border px-4 py-2 font-bold text-left align-middle">Kode Sales</th>
                    <th class="border px-4 py-2 font-bold text-left align-middle">Nama Sales</th>
                    <th class="border px-4 py-2 font-bold text-left align-middle">Agency</th>
                    <th class="border px-4 py-2 font-bold text-center align-middle">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm">
                @foreach ($sales as $index => $sale)
                    <tr class="border-t hover:bg-gray-100 transition">
                        <td class="px-4 py-2 text-left align-middle">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2 text-left align-middle">
                            <div class="w-10 h-10 flex items-center">
                                <img src="{{ asset('storage/' . $sale->gambar_sales) }}" alt="gambar"
                                    class="w-8 h-8 rounded-full object-cover border mx-auto">
                            </div>
                        </td>
                        <td class="px-4 py-2 text-left align-middle">{{ $sale->kode_sales }}</td>
                        <td class="px-4 py-2 text-left align-middle">{{ $sale->nama_sales }}</td>
                        <td class="px-4 py-2 text-left align-middle">{{ $sale->agency }}</td>
                        <td class="px-4 py-2 text-center align-middle space-x-1">
                            <a href="{{ route('sales.edit', $sale->id) }}"
                                class="bg-green-500 hover:bg-green-600 text-white px-2 py-1 rounded text-xs transition-colors">Edit</a>
                            <button @click="openDeleteModal = true; deleteUrl = '{{ route('sales.destroy', $sale->id) }}'"
                                class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-xs transition-colors">
                                Hapus
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            </table>
        </div>
    @else
        <div class="text-center text-gray-500 mt-8">
            Tidak ditemukan data sales.
        </div>
    @endif

    {{-- Modal Tambah Sales --}}
    <div x-show="openAddModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 p-4" x-cloak>
        <div @click.away="openAddModal = false" class="bg-white rounded-lg shadow-xl p-8 w-full max-w-md transition-all">
            <h2 class="text-2xl font-bold mb-6 text-center">Tambah</h2>

            <form action="{{ route('sales.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Gambar Sales</label>
                    <div class="flex flex-col items-center space-y-2">
                        <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center overflow-hidden">
                            <img id="preview-image" src="#" alt="Preview" class="w-full h-full object-cover hidden rounded-lg" />
                            <svg id="placeholder-icon" class="w-10 h-10 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="flex items-center w-full">
                            <input type="file" id="gambar_sales" name="gambar_sales" class="hidden" accept="image/*"
                                onchange="previewGambar(event)">
                            <label for="gambar_sales"
                                class="cursor-pointer bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded-l-md text-sm font-medium border border-gray-300">
                                Pilih File
                            </label>
                            <span id="file-name" class="flex-1 px-3 py-2 border border-gray-300 rounded-r-md text-sm text-gray-500 bg-white truncate">
                                Belum ada file
                            </span>
                        </div>
                        @error('gambar_sales')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Kode Sales</label>
                    <input type="text" name="kode_sales" value="{{ old('kode_sales') }}"
                        class="w-full mt-1 border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    @error('kode_sales')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Nama Sales</label>
                    <input type="text" name="nama_sales" value="{{ old('nama_sales') }}"
                        class="w-full mt-1 border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    @error('nama_sales')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Agency</label>
                    <input type="text" name="agency" value="{{ old('agency') }}"
                        class="w-full mt-1 border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    @error('agency')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end space-x-2 pt-4">
                    <button type="button" @click="openAddModal = false"
                        class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-md text-sm font-medium transition-colors border border-gray-300">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md text-sm font-medium transition-colors">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Script untuk preview gambar --}}
<script>
    function previewGambar(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('preview-image');
        const placeholder = document.getElementById('placeholder-icon');
        const fileName = document.getElementById('file-name');

        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
            };
            reader.readAsDataURL(file);

            fileName.textContent = file.name;
        } else {
            preview.src = '';
            preview.classList.add('hidden');
            placeholder.classList.remove('hidden');
            fileName.textContent = 'Belum ada file';
        }
    }
</script>
@endsection
