@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
    <h2 class="text-3xl font-bold text-gray-800 mb-6">Dashboard Admin</h2>

    <div class="bg-white rounded-lg shadow-md p-6 border-2 flex flex-col items-center justify-center gap-y-6">
        <!-- Filter Tanggal -->
        <div class="self-end">
            <form id="date-form" method="GET" action="{{ route('pelanggan.index') }}">
                <div class="flex items-center space-x-2 text-gray-500 text-sm">
                    <div id="date-range-picker" date-rangepicker class="flex items-center">
                        <!-- Start Date -->
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                </svg>
                            </div>
                            <input id="datepicker-range-start" name="start" type="text"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg 
                                                                                                   focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 
                                                                                                   dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 
                                                                                                   dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Mulai tanggal">
                        </div>

                        <span class="mx-4 text-gray-500">to</span>

                        <!-- End Date -->
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                </svg>
                            </div>
                            <input id="datepicker-range-end" name="end" type="text"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg 
                                                                                                   focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 
                                                                                                   dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 
                                                                                                   dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Sampai tanggal">
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button class="bg-gray-200 hover:bg-gray-300 rounded-md p-1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6.75 3v2.25M17.25 3v2.25M3 
                                                                                               18.75V7.5a2.25 2.25 0 0 1 
                                                                                               2.25-2.25h13.5A2.25 2.25 0 0 1 
                                                                                               21 7.5v11.25m-18 0A2.25 2.25 
                                                                                               0 0 0 5.25 21h13.5A2.25 2.25 
                                                                                               0 0 0 21 18.75m-18 0v-7.5A2.25 
                                                                                               2.25 0 0 1 5.25 9h13.5A2.25 
                                                                                               2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12
                                                                                               v-.008ZM12 15h.008v.008H12V15Zm0 
                                                                                               2.25h.008v.008H12v-.008ZM9.75 
                                                                                               15h.008v.008H9.75V15Zm0 
                                                                                               2.25h.008v.008H9.75v-.008ZM7.5 
                                                                                               15h.008v.008H7.5V15Zm0 
                                                                                               2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008
                                                                                               v-.008Zm0 2.25h.008v.008h-.008V15Zm0 
                                                                                               2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5
                                                                                               v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>

        <!-- Cards -->
        <div class="w-full flex justify-between">
            <!-- Total Sales -->
            <div class="min-w-[280px] border-2 p-4 rounded-2xl flex gap-4 items-center">
                <div class="p-2 bg-blue-600 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                        class="size-14 text-white">
                        <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 1 1 
                                                                                           9 0 4.5 4.5 0 0 1-9 0ZM3.751 
                                                                                           20.105a8.25 8.25 0 0 1 
                                                                                           16.498 0 .75.75 0 0 
                                                                                           1-.437.695A18.683 18.683 0 0 1 
                                                                                           12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 
                                                                                           0 0 1-.437-.695Z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="flex flex-col items-center justify-center">
                    <h2 class="text-3xl font-bold">{{ $sales->count() }}</h2>
                    <p>Total Sales Assistant</p>
                </div>
            </div>

            <!-- Total Pelanggan -->
            <div class="min-w-[280px] border-2 p-4 rounded-2xl flex gap-4 items-center">
                <div class="p-2 bg-blue-600 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                        class="size-14 text-white">
                        <path fill-rule="evenodd" d="M8.25 6.75a3.75 3.75 0 1 
                                                                                           1 7.5 0 3.75 3.75 0 0 1-7.5 
                                                                                           0ZM15.75 9.75a3 3 0 1 1 
                                                                                           6 0 3 3 0 0 1-6 0ZM2.25 
                                                                                           9.75a3 3 0 1 1 6 0 3 3 0 
                                                                                           0 1-6 0ZM6.31 15.117A6.745 
                                                                                           6.745 0 0 1 12 12a6.745 
                                                                                           6.745 0 0 1 6.709 
                                                                                           7.498.75.75 0 0 
                                                                                           1-.372.568A12.696 
                                                                                           12.696 0 0 1 
                                                                                           12 21.75c-2.305 0-4.47-.612-6.337-1.684a.75.75 
                                                                                           0 0 1-.372-.568 
                                                                                           6.787 6.787 0 0 1 
                                                                                           1.019-4.38Z"
                            clip-rule="evenodd" />
                        <path
                            d="M5.082 14.254a8.287 
                                                                                           8.287 0 0 0-1.308 
                                                                                           5.135 9.687 9.687 
                                                                                           0 0 1-1.764-.44l-.115-.04a.563.563 
                                                                                           0 0 1-.373-.487l-.01-.121a3.75 
                                                                                           3.75 0 0 1 3.57-4.047ZM20.226 
                                                                                           19.389a8.287 8.287 0 0 0-1.308-5.135 
                                                                                           3.75 3.75 0 0 1 3.57 
                                                                                           4.047l-.01.121a.563.563 
                                                                                           0 0 1-.373.486l-.115.04c-.567.2-1.156.349-1.764.441Z" />
                    </svg>
                </div>
                <div class="flex flex-col items-center justify-center">
                    <h2 class="text-3xl font-bold">{{ $pelanggan->count() }}</h2>
                    <p>Total Pelanggan</p>
                </div>
            </div>

            <!-- Total Astinet -->
            <div class="min-w-[280px] border-2 p-4 rounded-2xl flex gap-4 items-center">
                <div class="p-2 bg-blue-600 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                        class="size-14 text-white">
                        <path d="M18.375 2.25c-1.035 
                                                                                           0-1.875.84-1.875 
                                                                                           1.875v15.75c0 
                                                                                           1.035.84 1.875 
                                                                                           1.875 1.875h.75c1.035 
                                                                                           0 1.875-.84 
                                                                                           1.875-1.875V4.125c0-1.036-.84-1.875-1.875-1.875h-.75ZM9.75 
                                                                                           8.625c0-1.036.84-1.875 
                                                                                           1.875-1.875h.75c1.036 0 
                                                                                           1.875.84 1.875 1.875v11.25c0 
                                                                                           1.035-.84 1.875-1.875 
                                                                                           1.875h-.75a1.875 
                                                                                           1.875 0 0 1-1.875-1.875V8.625ZM3 
                                                                                           13.125c0-1.036.84-1.875 
                                                                                           1.875-1.875h.75c1.036 0 
                                                                                           1.875.84 1.875 
                                                                                           1.875v6.75c0 1.035-.84 
                                                                                           1.875-1.875 1.875h-.75A1.875 
                                                                                           1.875 0 0 1 3 19.875v-6.75Z" />
                    </svg>
                </div>
                <div class="flex flex-col items-center justify-center">
                    <h2 class="text-3xl font-bold">101</h2>
                    <p>Total Astinet</p>
                </div>
            </div>
        </div>

        <div class="w-full flex gap-10 justify-between">
            <!-- Ranking Sales -->
            <div class="w-1/2 flex flex-col gap-4">
                <div class="bg-blue-600 p-4 rounded-xl text-white">Top Ranking Sales</div>
                <div class="overflow-x-auto rounded-xl">
                    <table class="min-w-full table-auto bg-white border border-gray-200 rounded text-sm">
                        <thead class="bg-blue-100 text-gray-700">
                            <tr>
                                <th class="border px-2 py-2 font-bold text-left align-middle">No</th>
                                <th class="border px-2 py-2 font-bold text-left align-middle">Gambar</th>
                                <th class="border px-2 py-2 font-bold text-left align-middle">Kode Sales</th>
                                <th class="border px-2 py-2 font-bold text-left align-middle">Nama Sales</th>
                                <th class="border px-2 py-2 font-bold text-left align-middle">ACH</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600">
                            @foreach ($sales as $index => $sale)
                                <tr class="border-t hover:bg-gray-100 transition">
                                    <td class="px-2 py-2 text-left align-middle">{{ $loop->iteration }}</td>
                                    <td class="px-2 py-2 text-left align-middle">
                                        <div class="w-10 h-10 flex items-center">
                                            <img src="{{ asset('storage/'.$sale->gambar_sales) }}" alt="gambar"
                                                class="w-8 h-8 rounded-full object-cover border mx-auto">
                                        </div>
                                    </td>
                                    <td class="px-2 py-2 text-left align-middle">{{ $sale->kode_sales }}</td>
                                    <td class="px-2 py-2 text-left align-middle">{{ $sale->nama_sales }}</td>
                                    <td class="px-2 py-2 text-left align-middle"> - %</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Racing Sales Agency -->
            <div class="w-1/2 flex flex-col gap-4">
                <div class="bg-blue-600 p-4 rounded-xl text-white">Ranking Sales Agency</div>
                <div class="overflow-x-auto rounded-xl">
                    <table class="min-w-full table-auto bg-white border border-gray-200 rounded text-sm">
                        <thead class="bg-blue-100 text-gray-700">
                            <tr>
                                <th class="border px-2 py-2 font-bold text-left align-middle">Agency</th>
                                <th class="border px-2 py-2 font-bold text-left align-middle">Target</th>
                                <th class="border px-2 py-2 font-bold text-left align-middle">Realisasi</th>
                                <th class="border px-2 py-2 font-bold text-left align-middle">ACH.</th>
                                <th class="border px-2 py-2 font-bold text-left align-middle">Rank</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600">
                            @foreach ($agency as $sale)
                                <tr class="border-t hover:bg-gray-100 transition">
                                    <td class="px-2 py-2 text-left align-middle">{{ $sale['agency'] }}</td>
                                    <td class="px-2 py-2 text-left align-middle">{{ $sale['target'] }}</td>
                                    <td class="px-2 py-2 text-left align-middle">{{ $sale['realisasi'] }}</td>
                                    <td class="px-2 py-2 text-left align-middle">{{ $sale['ach'] }}</td>
                                    <td class="px-2 py-2 text-left align-middle">{{ $sale['rank'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection