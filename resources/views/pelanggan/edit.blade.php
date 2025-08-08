@extends('layouts.app')

@section('title', 'Edit Data Pelanggan')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6 min-h-[calc(100vh-160px)] max-w-3xl mx-auto relative">
    <button onclick="window.history.back()" class="flex items-center text-gray-600 hover:text-gray-900 focus:outline-none mb-6" aria-label="Kembali">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
        Kembali
    </button>
    <h2 class="text-2xl font-bold mb-6 text-center">Edit</h2>

    <form action="{{ route('pelanggan.update', ['id' => $pelanggan['id'] ?? 1]) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="space-y-4">
            <div>
                <label for="no_internet" class="block text-gray-700 font-semibold mb-1">No Internet</label>
                <input type="text" id="no_internet" name="no_internet" value="{{ old('no_internet', $pelanggan['no_internet'] ?? '') }}" class="w-full border border-gray-300 rounded px-4 py-2" />
            </div>
            <div>
                <label for="no_digital" class="block text-gray-700 font-semibold mb-1">No Digital</label>
                <input type="text" id="no_digital" name="no_digital" value="{{ old('no_digital', $pelanggan['no_digital'] ?? '') }}" class="w-full border border-gray-300 rounded px-4 py-2" />
            </div>
            <div class="grid grid-cols-4 gap-4">
                <div>
                    <label for="tanggal_ps" class="block text-gray-700 font-semibold mb-1">Tanggal PS</label>
                    <input type="date" id="tanggal_ps" name="tanggal_ps" value="{{ old('tanggal_ps', $pelanggan['tanggal_ps'] ?? '') }}" class="w-full border border-gray-300 rounded px-4 py-2" />
                </div>
                <div>
                    <label for="kecepatan" class="block text-gray-700 font-semibold mb-1">Kecepatan</label>
                    <input type="number" id="kecepatan" name="kecepatan" value="{{ old('kecepatan', $pelanggan['kecepatan'] ?? '') }}" class="w-full border border-gray-300 rounded px-4 py-2" />
                </div>
                <div>
                    <label for="bulan" class="block text-gray-700 font-semibold mb-1">Bulan</label>
                    <input type="number" id="bulan" name="bulan" value="{{ old('bulan', $pelanggan['bulan'] ?? '') }}" class="w-full border border-gray-300 rounded px-4 py-2" />
                </div>
                <div>
                    <label for="tahun" class="block text-gray-700 font-semibold mb-1">Tahun</label>
                    <input type="number" id="tahun" name="tahun" value="{{ old('tahun', $pelanggan['tahun'] ?? '') }}" class="w-full border border-gray-300 rounded px-4 py-2" />
                </div>
            </div>

            <div class="grid grid-cols-4 gap-4">
                <div>
                    <label for="datel" class="block text-gray-700 font-semibold mb-1">Datel</label>
                    <input type="text" id="datel" name="datel" value="{{ old('datel', $pelanggan['datel'] ?? '') }}" class="w-full border border-gray-300 rounded px-4 py-2" />
                </div>
                <div>
                    <label for="ro" class="block text-gray-700 font-semibold mb-1">RO</label>
                    <input type="text" id="ro" name="ro" value="{{ old('ro', $pelanggan['ro'] ?? '') }}" class="w-full border border-gray-300 rounded px-4 py-2" />
                </div>
                <div>
                    <label for="sto" class="block text-gray-700 font-semibold mb-1">STO</label>
                    <input type="text" id="sto" name="sto" value="{{ old('sto', $pelanggan['sto'] ?? '') }}" class="w-full border border-gray-300 rounded px-4 py-2" />
                </div>
                <div>
                    <label for="nama" class="block text-gray-700 font-semibold mb-1">Nama</label>
                    <input type="text" id="nama" name="nama" value="{{ old('nama', $pelanggan['nama'] ?? '') }}" class="w-full border border-gray-300 rounded px-4 py-2" />
                </div>
            </div>

            <div class="grid grid-cols-4 gap-4">
                <div>
                    <label for="segmen" class="block text-gray-700 font-semibold mb-1">Segmen</label>
                    <input type="text" id="segmen" name="segmen" value="{{ old('segmen', $pelanggan['segmen'] ?? '') }}" class="w-full border border-gray-300 rounded px-4 py-2" />
                </div>
                <div>
                    <label for="kcontact" class="block text-gray-700 font-semibold mb-1">Kcontact</label>
                    <input type="text" id="kcontact" name="kcontact" value="{{ old('kcontact', $pelanggan['kcontact'] ?? '') }}" class="w-full border border-gray-300 rounded px-4 py-2" />
                </div>
                <div>
                    <label for="jenis_layanan" class="block text-gray-700 font-semibold mb-1">Jenis Layanan</label>
                    <input type="text" id="jenis_layanan" name="jenis_layanan" value="{{ old('jenis_layanan', $pelanggan['jenis_layanan'] ?? '') }}" class="w-full border border-gray-300 rounded px-4 py-2" />
                </div>
                <div>
                    <label for="channel_1" class="block text-gray-700 font-semibold mb-1">Channel 1</label>
                    <input type="text" id="channel_1" name="channel_1" value="{{ old('channel_1', $pelanggan['channel_1'] ?? '') }}" class="w-full border border-gray-300 rounded px-4 py-2" />
                </div>
            </div>
                <div class="col-span-2">
                    <label for="kode_sales" class="block text-gray-700 font-semibold mb-1">Kode Sales</label>
                    <select id="kode_sales" name="kode_sales" class="w-full border border-gray-300 rounded px-4 py-2">
                        <option value="MN00101" {{ old('kode_sales', $pelanggan['kode_sales'] ?? '') == 'MN00101' ? 'selected' : '' }}>MN00101</option>
                        <option value="MN00102" {{ old('kode_sales', $pelanggan['kode_sales'] ?? '') == 'MN00102' ? 'selected' : '' }}>MN00102</option>
                        <option value="MN00103" {{ old('kode_sales', $pelanggan['kode_sales'] ?? '') == 'MN00103' ? 'selected' : '' }}>MN00103</option>
                    </select>
                </div>
                <div>
                    <label for="nama_sf" class="block text-gray-700 font-semibold mb-1">Nama SF</label>
                    <select id="nama_sf" name="nama_sf" class="w-full border border-gray-300 rounded px-4 py-2">
                        <option value="Herlita" {{ old('nama_sf', $pelanggan['nama_sf'] ?? '') == 'Herlita' ? 'selected' : '' }}>Herlita</option>
                        <option value="Bagas" {{ old('nama_sf', $pelanggan['nama_sf'] ?? '') == 'Bagas' ? 'selected' : '' }}>Bagas</option>
                    </select>
                </div>
                <div>
                    <label for="agency" class="block text-gray-700 font-semibold mb-1">Agency</label>
                    <select id="agency" name="agency" class="w-full border border-gray-300 rounded px-4 py-2">
                        <option value="MCA" {{ old('agency', $pelanggan['agency'] ?? '') == 'MCA' ? 'selected' : '' }}>MCA</option>
                        <option value="MCA2" {{ old('agency', $pelanggan['agency'] ?? '') == 'MCA2' ? 'selected' : '' }}>MCA2</option>
                        <option value="MCA3" {{ old('agency', $pelanggan['agency'] ?? '') == 'MCA3' ? 'selected' : '' }}>MCA3</option>
                    </select>
                </div>
            </div>

        </div>

        <div class="flex justify-end space-x-4 mt-6">
            <button type="button" onclick="window.history.back()" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-6 rounded transition-colors duration-200">
                Batal
            </button>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded transition-colors duration-200">
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection
