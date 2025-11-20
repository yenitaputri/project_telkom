@extends('layouts.app')

@section('title', 'Edit Data Astinet')

@section('content')
<div class="bg-white rounded-lg shadow p-6 max-w-2xl mx-auto min-h-[calc(100vh-160px)]">

    <h2 class="text-xl font-semibold mb-4">Edit Data Astinet</h2>

    <form action="{{ route('astinet.update', $astinet->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Input Component --}}
        @php
            function inputClass($error) {
                return $error
                    ? 'w-full border border-red-500 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-400'
                    : 'w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500';
            }
        @endphp

        {{-- Kode Order --}}
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Kode Order</label>
            <input type="text" name="kode_order"
                value="{{ old('kode_order', $astinet->kode_order) }}"
                class="{{ inputClass($errors->has('kode_order')) }}">
            @error('kode_order')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- SID --}}
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">SID</label>
            <input type="text" name="sid"
                value="{{ old('sid', $astinet->sid) }}"
                class="{{ inputClass($errors->has('sid')) }}">
            @error('sid')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Bandwidth --}}
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Besar Bandwidth</label>
            <input type="text" name="bandwidth"
                value="{{ old('bandwidth', $astinet->bandwidth) }}"
                class="{{ inputClass($errors->has('bandwidth')) }}">
            @error('bandwidth')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Nama Pelanggan --}}
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Nama Pelanggan</label>
            <input type="text" name="nama_pelanggan"
                value="{{ old('nama_pelanggan', $astinet->nama_pelanggan) }}"
                class="{{ inputClass($errors->has('nama_pelanggan')) }}">
            @error('nama_pelanggan')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Sales --}}
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Sales</label>

            <select
                name="nama_sales"
                class="{{ $errors->has('kode_sales')
                    ? 'w-full border border-red-500 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-400'
                    : 'w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500'
                }}"
            >
                <option value="">-- Pilih Sales --</option>
                @foreach ($sales as $sale)
                    <option
                        value="{{ $sale->kode_sales }}"
                        {{ old('nama_sales', $astinet->kode_sales) == $sale->kode_sales ? 'selected' : '' }}
                    >
                        {{ $sale->kode_sales }} — {{ $sale->nama_sales }}
                    </option>
                @endforeach
            </select>

            @error('nama_sales')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Tanggal Complete --}}
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Tanggal Complete</label>

            <input type="date" name="tanggal_complete"
                value="{{ old('tanggal_complete', optional($astinet->tanggal_complete ? \Carbon\Carbon::parse($astinet->tanggal_complete) : null)->format('Y-m-d')) }}"
                class="{{ inputClass($errors->has('tanggal_complete')) }}"
            >

            @error('tanggal_complete')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Buttons --}}
        <div class="flex justify-end">
            <a href="{{ route('astinet.index') }}"
               class="mr-2 px-4 py-2 rounded bg-gray-300 hover:bg-gray-400 text-gray-700 transition">
                Batal
            </a>

            <button type="submit"
                class="px-4 py-2 rounded bg-green-600 hover:bg-green-700 text-white transition">
                Update
            </button>
        </div>

    </form>

</div>
@endsection
