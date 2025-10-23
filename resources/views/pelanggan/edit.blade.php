@extends('layouts.app')

@section('title', 'Edit Data Pelanggan')

@section('content')
    <form action="{{ route('pelanggan.update', ['id' => $pelanggan->id, 'page' => $page]) }}" method="POST"
        class="space-y-6">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-lg shadow-md p-6 min-h-[calc(100vh-160px)] max-w-3xl mx-auto relative">
            {{-- Tombol kembali --}}
            <a href="{{ route('pelanggan.index', ['page' => $page]) }}"
                class="flex items-center text-gray-600 hover:text-gray-900 focus:outline-none mb-6" aria-label="Kembali">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali
            </a>

            <h2 class="text-2xl font-bold mb-6 text-center">Edit Pelanggan</h2>

            {{-- Form input --}}
            <div class="space-y-4">
                {{-- No Internet --}}
                <div>
                    <label for="no_internet" class="block text-gray-700 font-semibold mb-1">No Internet</label>
                    <input type="text" id="no_internet" name="no_internet"
                        value="{{ old('no_internet', $pelanggan->no_internet) }}"
                        class="w-full border border-gray-300 rounded px-4 py-2" />
                    @error('no_internet')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- No Digital --}}
                <div>
                    <label for="no_digital" class="block text-gray-700 font-semibold mb-1">No Digital</label>
                    <input type="text" id="no_digital" name="no_digital"
                        value="{{ old('no_digital', $pelanggan->no_digital) }}"
                        class="w-full border border-gray-300 rounded px-4 py-2" />
                    @error('no_digital')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Baris tanggal dan kecepatan --}}
                <div class="grid grid-cols-4 gap-4">
                    <div>
                        <label for="tanggal_ps" class="block text-gray-700 font-semibold mb-1">Tanggal PS</label>
                        <input type="date" id="tanggal_ps" name="tanggal_ps"
                            value="{{ old('tanggal_ps', $pelanggan->tanggal_ps) }}"
                            class="w-full border border-gray-300 rounded px-4 py-2" />
                    </div>
                    <div>
                        <label for="kecepatan" class="block text-gray-700 font-semibold mb-1">Kecepatan</label>
                        <input type="number" id="kecepatan" name="kecepatan"
                            value="{{ old('kecepatan', $pelanggan->kecepatan) }}"
                            class="w-full border border-gray-300 rounded px-4 py-2" />
                    </div>
                    <div>
                        <label for="bulan" class="block text-gray-700 font-semibold mb-1">Bulan</label>
                        <input type="number" id="bulan" name="bulan" value="{{ old('bulan', $pelanggan->bulan) }}"
                            class="w-full border border-gray-300 rounded px-4 py-2" />
                    </div>
                    <div>
                        <label for="tahun" class="block text-gray-700 font-semibold mb-1">Tahun</label>
                        <input type="number" id="tahun" name="tahun" value="{{ old('tahun', $pelanggan->tahun) }}"
                            class="w-full border border-gray-300 rounded px-4 py-2" />
                    </div>
                </div>

                {{-- Datel, RO, STO, Nama --}}
                <div class="grid grid-cols-4 gap-4">
                    @foreach (['datel' => 'Datel', 'ro' => 'RO', 'sto' => 'STO', 'nama' => 'Nama'] as $field => $label)
                        <div>
                            <label for="{{ $field }}" class="block text-gray-700 font-semibold mb-1">{{ $label }}</label>
                            <input type="text" id="{{ $field }}" name="{{ $field }}"
                                value="{{ old($field, $pelanggan->$field) }}"
                                class="w-full border border-gray-300 rounded px-4 py-2" />
                        </div>
                    @endforeach
                </div>

                {{-- Segmen, kcontact, jenis layanan, channel --}}
                <div class="grid grid-cols-4 gap-4">
                    @foreach (['segmen' => 'Segmen', 'kcontact' => 'Kcontact', 'jenis_layanan' => 'Jenis Layanan', 'channel_1' => 'Channel 1'] as $field => $label)
                        <div>
                            <label for="{{ $field }}" class="block text-gray-700 font-semibold mb-1">{{ $label }}</label>
                            <input type="text" id="{{ $field }}" name="{{ $field }}"
                                value="{{ old($field, $pelanggan->$field) }}"
                                class="w-full border border-gray-300 rounded px-4 py-2" />
                        </div>
                    @endforeach
                </div>

                {{-- Dropdown sales dinamis --}}
                <div>
                    <label for="kode_sales" class="block text-gray-700 font-semibold mb-1">Kode Sales</label>
                    <select id="kode_sales" name="kode_sales" class="w-full border border-gray-300 rounded px-4 py-2">
                        {{-- Opsi kosong jika kode_sales null --}}
                        <option value="" {{ old('kode_sales', $pelanggan->kode_sales) == null ? 'selected' : '' }}>
                            -- Pilih Kode Sales --
                        </option>

                        @foreach ($sales as $s)
                            <option value="{{ $s->kode_sales }}" data-nama-sf="{{ $s->nama_sales }}"
                                data-agency="{{ $s->agency }}" {{ old('kode_sales', $pelanggan->kode_sales) == $s->kode_sales ? 'selected' : '' }}>
                                {{ $s->kode_sales }} - {{ $s->nama_sales }}
                            </option>
                        @endforeach
                    </select>
                </div>


                {{-- Nama SF (readonly) --}}
                <div>
                    <label for="nama_sales" class="block text-gray-700 font-semibold mb-1">Nama SF</label>
                    <input type="text" id="nama_sales" name="nama_sales"
                        value="{{ old('nama_sales', $pelanggan->sales->nama_sales ?? '') }}"
                        class="w-full border border-gray-300 rounded px-4 py-2 bg-gray-100" readonly />
                </div>

                {{-- Agency (readonly) --}}
                <div>
                    <label for="agency" class="block text-gray-700 font-semibold mb-1">Agency</label>
                    <input type="text" id="agency" name="agency"
                        value="{{ old('agency', $pelanggan->sales->agency ?? '') }}"
                        class="w-full border border-gray-300 rounded px-4 py-2 bg-gray-100" readonly />
                </div>
            </div>
        </div>

        {{-- Tombol aksi --}}
        <div class="flex justify-end space-x-4 mt-6 max-w-3xl mx-auto">
            <a href="{{ route('pelanggan.index', ['page' => $page]) }}"
                class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-6 rounded transition-colors duration-200">
                Batal
            </a>
            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded transition-colors duration-200">
                Simpan
            </button>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const kodeSalesSelect = document.getElementById('kode_sales');
            const namaSfInput = document.getElementById('nama_sales');
            const agencyInput = document.getElementById('agency');

            function updateFields() {
                const selected = kodeSalesSelect.options[kodeSalesSelect.selectedIndex];
                const kode = selected.value;

                if (kode === '') {
                    namaSfInput.value = '';
                    agencyInput.value = '';
                    return;
                }

                namaSfInput.value = selected.getAttribute('data-nama-sf') || '';
                agencyInput.value = selected.getAttribute('data-agency') || '';
            }

            kodeSalesSelect.addEventListener('change', updateFields);
            updateFields(); // Inisialisasi awal
        });
    </script>
@endsection