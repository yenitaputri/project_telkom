@extends('layouts.app')

@section('title', 'Detail Data Prodigi')

@section('content')
    <div class="bg-white rounded-lg shadow-md p-6 min-h-[calc(100vh-160px)] max-w-4xl mx-auto relative">
        {{-- Tombol close / kembali --}}
        <a href="{{ route('prodigi.index') }}"
            class="absolute top-4 right-4 text-gray-600 hover:text-gray-900 focus:outline-none" aria-label="Kembali">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </a>

        <h2 class="text-2xl font-bold mb-6 text-center">Detail Data Prodigi</h2>

        <div class="bg-gray-50 rounded-lg p-6">
            <table class="w-full text-sm text-left text-gray-700">
                <tbody>
                    <tr class="border-b">
                        <th class="py-3 px-4 font-semibold w-1/3">Order ID</th>
                        <td class="py-3 px-4">{{ $prodigi->order_id }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="py-3 px-4 font-semibold">Witel</th>
                        <td class="py-3 px-4">{{ $prodigi->witel }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="py-3 px-4 font-semibold">Telda</th>
                        <td class="py-3 px-4">{{ $prodigi->telda }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="py-3 px-4 font-semibold">Paket</th>
                        <td class="py-3 px-4">{{ $prodigi->paket }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="py-3 px-4 font-semibold">Tanggal PS</th>
                        <td class="py-3 px-4">{{ $prodigi->tanggal_ps }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="py-3 px-4 font-semibold">ND</th>
                        <td class="py-3 px-4">{{ $prodigi->nd }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="py-3 px-4 font-semibold">Customer Name</th>
                        <td class="py-3 px-4">{{ $prodigi->customer_name }}</td>
                    </tr>
                    <tr class="border-b">
                        <th class="py-3 px-4 font-semibold">REV</th>
                        <td class="py-3 px-4">{{ $prodigi->rev }}</td>
                    <tr>
                        <th class="py-3 px-4 font-semibold">Device</th>
                        <td class="py-3 px-4">{{ $prodigi->device }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="flex justify-end space-x-4 mt-6">

            <a href="{{ route('prodigi.edit', ['id' => $prodigi['id'], 'page' => request('page', 1)]) }}"
                class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded transition-colors duration-200 inline-block text-center">Edit</a>
            <button
                class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded transition-colors duration-200"
                onclick="confirmDelete({{ $prodigi->id }})">Hapus</button>
        </div>

        <!-- Form hapus tersembunyi -->
        <form id="delete-form-{{ $prodigi->id }}" action="{{ route('prodigi.destroy', $prodigi->id) }}" method="POST"
            class="hidden">
            @csrf
            @method('DELETE')
        </form>

        <!-- <div class="flex justify-end space-x-4 mt-6">
            <a href="{{ route('prodigi.index') }}"
                class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded transition-colors duration-200">
                Kembali
            </a>
        </div> -->
    </div>
@endsection