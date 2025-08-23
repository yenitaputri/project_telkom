@extends('layouts.app')

@section('title', 'Edit Data Prodigi')

@section('content')
    <form action="{{ route('prodigi.update', ['id' => $prodigi->id, 'page' => request('page', 1)]) }}" method="POST"
        class="space-y-6">
        <div class="bg-white rounded-lg shadow-md p-6 min-h-[calc(100vh-160px)] max-w-3xl mx-auto relative">
            <a href="{{ route('prodigi.index') }}"
                class="flex items-center text-gray-600 hover:text-gray-900 focus:outline-none mb-6" aria-label="Kembali">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali
            </a>
            <h2 class="text-2xl font-bold mb-6 text-center">Edit Data Prodigi</h2>

            @csrf
            @method('PUT')

            <div class="space-y-4">
                <div>
                    <label for="order_id" class="block text-gray-700 font-semibold mb-1">Order ID</label>
                    <input type="text" id="order_id" name="order_id" value="{{ old('order_id', $prodigi->order_id ?? '') }}"
                        class="w-full border border-gray-300 rounded px-4 py-2" />
                    @error('order_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="nd" class="block text-gray-700 font-semibold mb-1">ND</label>
                    <input type="text" id="nd" name="nd" value="{{ old('nd', $prodigi->nd ?? '') }}"
                        class="w-full border border-gray-300 rounded px-4 py-2" />
                    @error('nd')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="customer_name" class="block text-gray-700 font-semibold mb-1">Customer Name</label>
                    <input type="text" id="customer_name" name="customer_name"
                        value="{{ old('customer_name', $prodigi->customer_name ?? '') }}"
                        class="w-full border border-gray-300 rounded px-4 py-2" />
                    @error('customer_name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="witel" class="block text-gray-700 font-semibold mb-1">Witel</label>
                        <input type="text" id="witel" name="witel" value="{{ old('witel', $prodigi->witel ?? '') }}"
                            class="w-full border border-gray-300 rounded px-4 py-2" />
                        @error('witel')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="telda" class="block text-gray-700 font-semibold mb-1">Telda</label>
                        <input type="text" id="telda" name="telda" value="{{ old('telda', $prodigi->telda ?? '') }}"
                            class="w-full border border-gray-300 rounded px-4 py-2" />
                        @error('telda')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="produk" class="block text-gray-700 font-semibold mb-1">Produk</label>
                    <input type="text" id="produk" name="produk" value="{{ old('produk', $prodigi->produk ?? '') }}"
                        class="w-full border border-gray-300 rounded px-4 py-2" />
                    @error('produk')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="tanggal_ps" class="block text-gray-700 font-semibold mb-1">Tanggal PS</label>
                        <input type="date" id="tanggal_ps" name="tanggal_ps"
                            value="{{ old('tanggal_ps', $prodigi->tanggal_ps ?? '') }}"
                            class="w-full border border-gray-300 rounded px-4 py-2" />
                        @error('tanggal_ps')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="rev" class="block text-gray-700 font-semibold mb-1">Rev</label>
                        <input type="number" id="rev" name="rev" value="{{ old('rev', $prodigi->rev ?? '') }}"
                            class="w-full border border-gray-300 rounded px-4 py-2" />
                        @error('rev')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="device" class="block text-gray-700 font-semibold mb-1">Device</label>
                    <input type="text" id="device" name="device" value="{{ old('device', $prodigi->device ?? '') }}"
                        class="w-full border border-gray-300 rounded px-4 py-2" />
                    @error('device')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="flex justify-end space-x-4 mt-6">
            <a href="{{ route('prodigi.index') }}"
                class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-6 rounded transition-colors duration-200">
                Batal
            </a>
            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded transition-colors duration-200">
                Simpan
            </button>
        </div>
    </form>
@endsection