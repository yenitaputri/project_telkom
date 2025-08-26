@extends('layouts.app')

@section('title', 'Detail Data Pelanggan')

@section('content')
    <div class="bg-white rounded-lg shadow-md p-6 min-h-[calc(100vh-160px)] max-w-4xl mx-auto relative">
        <a href="{{ route('pelanggan.index') }}"
            class="absolute top-4 right-4 text-gray-600 hover:text-gray-900 focus:outline-none" aria-label="Close">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </a>
        <h2 class="text-2xl font-bold mb-6 text-center">Detail Data</h2>
        <table class="w-full text-sm text-left text-gray-700 border border-gray-200 rounded-lg">
            <tbody>
                <tr>
                    <th class="py-2 px-4 font-semibold border-b">No Internet</th>
                    <td class="py-2 px-4 border-b">{{ $pelanggan['no_internet'] }}</td>
                </tr>
                <tr>
                    <th class="py-2 px-4 font-semibold border-b">No Digital</th>
                    <td class="py-2 px-4 border-b">{{ $pelanggan['no_digital'] }}</td>
                </tr>
                <tr>
                    <th class="py-2 px-4 font-semibold border-b">Regional</th>
                    <td class="py-2 px-4 border-b">{{ $pelanggan['regional'] }}</td>
                </tr>
                <tr>
                    <th class="py-2 px-4 font-semibold border-b">Tanggal PS</th>
                    <td class="py-2 px-4 border-b">
                        {{ \Carbon\Carbon::parse($pelanggan['tanggal_ps'])->format('m/d/Y') }}
                    </td>
                </tr>
                <tr>
                    <th class="py-2 px-4 font-semibold border-b">Kecepatan</th>
                    <td class="py-2 px-4 border-b">{{ $pelanggan['kecepatan'] }}</td>
                </tr>
                <tr>
                    <th class="py-2 px-4 font-semibold border-b">Bulan</th>
                    <td class="py-2 px-4 border-b">{{ $pelanggan['bulan'] }}</td>
                </tr>
                <tr>
                    <th class="py-2 px-4 font-semibold border-b">Tahun</th>
                    <td class="py-2 px-4 border-b">{{ $pelanggan['tahun'] }}</td>
                </tr>
                <tr>
                    <th class="py-2 px-4 font-semibold border-b">Datel</th>
                    <td class="py-2 px-4 border-b">{{ $pelanggan['datel'] }}</td>
                </tr>
                <tr>
                    <th class="py-2 px-4 font-semibold border-b">RO</th>
                    <td class="py-2 px-4 border-b">{{ $pelanggan['ro'] }}</td>
                </tr>
                <tr>
                    <th class="py-2 px-4 font-semibold border-b">STO</th>
                    <td class="py-2 px-4 border-b">{{ $pelanggan['sto'] }}</td>
                </tr>
                <tr>
                    <th class="py-2 px-4 font-semibold border-b">Nama</th>
                    <td class="py-2 px-4 border-b">{{ $pelanggan['nama'] }}</td>
                </tr>
                <tr>
                    <th class="py-2 px-4 font-semibold border-b">Segmen</th>
                    <td class="py-2 px-4 border-b">{{ $pelanggan['segmen'] }}</td>
                </tr>
                <tr>
                    <th class="py-2 px-4 font-semibold border-b">Kcontact</th>
                    <td class="py-2 px-4 border-b">{{ $pelanggan['kcontact'] }}</td>
                </tr>
                <tr>
                    <th class="py-2 px-4 font-semibold border-b">Channel</th>
                    <td class="py-2 px-4 border-b">{{ $pelanggan['channel'] }}</td>
                </tr>
                <tr>
                    <th class="py-2 px-4 font-semibold border-b">Jenis Layanan</th>
                    <td class="py-2 px-4 border-b">{{ $pelanggan['jenis_layanan'] }}</td>
                </tr>
                <tr>
                    <th class="py-2 px-4 font-semibold border-b">Cek Netmonk</th>
                    <td class="py-2 px-4 border-b"></td>
                </tr>
                <tr>
                    <th class="py-2 px-4 font-semibold border-b">Cek Pijar Mahir</th>
                    <td class="py-2 px-4 border-b"></td>
                </tr>
                <tr>
                    <th class="py-2 px-4 font-semibold border-b">Cek Eazy Cam</th>
                    <td class="py-2 px-4 border-b"></td>
                </tr>
                <tr>
                    <th class="py-2 px-4 font-semibold border-b">Cek Oca</th>
                    <td class="py-2 px-4 border-b"></td>
                </tr>
                <tr>
                    <th class="py-2 px-4 font-semibold border-b">Cek Pijar Sekolah</th>
                    <td class="py-2 px-4 border-b"></td>
                </tr>
                <tr>
                    <th class="py-2 px-4 font-semibold border-b">Kode Sales</th>
                    <td class="py-2 px-4 border-b">{{ $pelanggan['kode_sales'] }}</td>
                </tr>
                <tr>
                    <th class="py-2 px-4 font-semibold border-b">Nama SF</th>
                    <td class="py-2 px-4 border-b">{{ $pelanggan['nama_sf'] }}</td>
                </tr>
                <tr>
                    <th class="py-2 px-4 font-semibold border-b">Agency</th>
                    <td class="py-2 px-4 border-b">{{ $pelanggan['agency'] }}</td>
                </tr>
            </tbody>
        </table>
        <div class="flex justify-end space-x-4 mt-6">

            <a href="{{ route('pelanggan.edit', ['id' => $pelanggan['id'], 'page' => request('page', 1)]) }}"
                class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded transition-colors duration-200 inline-block text-center">Edit</a>
            <button
                class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded transition-colors duration-200"
                onclick="confirmDelete({{ $pelanggan->id }})">Hapus</button>
        </div>

        <!-- Form hapus tersembunyi -->
        <form id="delete-form-{{ $pelanggan->id }}" action="{{ route('pelanggan.destroy', $pelanggan->id) }}" method="POST"
            class="hidden">
            @csrf
            @method('DELETE')
        </form>
    </div>
@endsection