@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
    <h2 class="text-3xl font-bold text-gray-800 mb-6">Dashboard Admin</h2>

    <div class="bg-white rounded-lg shadow-md p-6 border-2 flex flex-col items-center justify-center gap-y-6">
        <!-- Filter Tanggal -->
        <div class="self-end">
            <form id="date-form" method="GET" action="{{ route('home.index') }}">
                <div class="flex items-center space-x-2 text-gray-500 text-sm">
                    <div class="flex items-center">
                        <!-- Start Date -->
                        <div class="relative">
                            <input id="datepicker-range-start" name="start" type="date"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg 
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                value="{{ request('start', \Carbon\Carbon::now()->startOfMonth()->format('Y-m-d')) }}">
                        </div>

                        <span class="mx-4 text-gray-500">s/d</span>

                        <!-- End Date -->
                        <div class="relative">
                            <input id="datepicker-range-end" name="end" type="date"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg 
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                value="{{ request('end', \Carbon\Carbon::now()->endOfMonth()->format('Y-m-d')) }}">
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white rounded-md p-2 px-4 transition duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                        </svg>
                    </button>

                    <!-- Reset Button -->
                    <button type="button" id="reset-btn"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-md p-2 px-4 transition duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
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
                        <path fill-rule="evenodd"
                            d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="flex flex-col items-center justify-center">
                    <h2 class="text-3xl font-bold">{{ $sales->count() }}</h2>
                    <p>Total Sales Assistant</p>
                    <p class="text-sm text-gray-500 mt-1">
                        {{ $sales->sum('pelanggans_count') }} Pelanggan
                    </p>
                </div>
            </div>

            <!-- Total Pelanggan -->
            <div class="min-w-[280px] border-2 p-4 rounded-2xl flex gap-4 items-center">
                <div class="p-2 bg-blue-600 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                        class="size-14 text-white">
                        <path fill-rule="evenodd"
                            d="M8.25 6.75a3.75 3.75 0 1 1 7.5 0 3.75 3.75 0 0 1-7.5 0ZM15.75 9.75a3 3 0 1 1 6 0 3 3 0 0 1-6 0ZM2.25 9.75a3 3 0 1 1 6 0 3 3 0 0 1-6 0ZM6.31 15.117A6.745 6.745 0 0 1 12 12a6.745 6.745 0 0 1 6.709 7.498.75.75 0 0 1-.372.568A12.696 12.696 0 0 1 12 21.75c-2.305 0-4.47-.612-6.337-1.684a.75.75 0 0 1-.372-.568 6.787 6.787 0 0 1 1.019-4.38Z"
                            clip-rule="evenodd" />
                        <path
                            d="M5.082 14.254a8.287 8.287 0 0 0-1.308 5.135 9.687 9.687 0 0 1-1.764-.44l-.115-.04a.563.563 0 0 1-.373-.487l-.01-.121a3.75 3.75 0 0 1 3.57-4.047ZM20.226 19.389a8.287 8.287 0 0 0-1.308-5.135 3.75 3.75 0 0 1 3.57 4.047l-.01.121a.563.563 0 0 1-.373.486l-.115.04c-.567.2-1.156.349-1.764.441Z" />
                    </svg>
                </div>
                <div class="flex flex-col items-center justify-center">
                    <h2 class="text-3xl font-bold">{{ $pelanggan->count() }}</h2>
                    <p>Total Pelanggan</p>
                    <p class="text-sm text-gray-500 mt-1">
                        Periode: {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} -
                        {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}
                    </p>
                </div>
            </div>

            <!-- Total Astinet -->
            <div class="min-w-[280px] border-2 p-4 rounded-2xl flex gap-4 items-center">
                <div class="p-2 bg-blue-600 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                        class="size-14 text-white">
                        <path
                            d="M18.375 2.25c-1.035 0-1.875.84-1.875 1.875v15.75c0 1.035.84 1.875 1.875 1.875h.75c1.035 0 1.875-.84 1.875-1.875V4.125c0-1.036-.84-1.875-1.875-1.875h-.75ZM9.75 8.625c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-.75a1.875 1.875 0 0 1-1.875-1.875V8.625ZM3 13.125c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v6.75c0 1.035-.84 1.875-1.875 1.875h-.75A1.875 1.875 0 0 1 3 19.875v-6.75Z" />
                    </svg>
                </div>
                <div class="flex flex-col items-center justify-center">
                    <h2 class="text-3xl font-bold">{{ $astinet }}</h2>
                    <p>Total Astinet</p>
                </div>
            </div>
        </div>

        <div class="w-full flex gap-10 justify-between">
            <!-- Ranking Sales -->
            <div class="w-1/2 flex flex-col gap-4" x-data="{ showAllSales: false }">
                <div class="bg-blue-600 p-4 rounded-xl text-white">Top Ranking Sales</div>
                <div class="overflow-x-auto rounded-xl">
                    <table class="min-w-full table-auto bg-white border border-gray-200 rounded text-sm">
                        <thead class="bg-blue-100 text-gray-700">
                            <tr>
                                <th class="border px-2 py-2 font-bold text-left align-middle">No</th>
                                <th class="border px-2 py-2 font-bold text-left align-middle">Gambar</th>
                                <th class="border px-2 py-2 font-bold text-left align-middle">Kode Sales</th>
                                <th class="border px-2 py-2 font-bold text-left align-middle">Nama Sales</th>
                                <th class="border px-2 py-2 font-bold text-left align-middle">Total Pelanggan</th>
                                <th class="border px-2 py-2 font-bold text-left align-middle">ACH</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600">
                            @forelse ($sales->sortByDesc('pelanggans_count') as $index => $sale)
                                <tr x-show="{{ $loop->iteration }} <= 5 || showAllSales" x-cloak
                                    class="border-t hover:bg-gray-100 transition">
                                    <td class="px-2 py-2 text-left align-middle">{{ $loop->iteration }}</td>
                                    <td class="px-2 py-2 text-left align-middle">
                                        <div class="w-10 h-10 flex items-center">
                                            <img src="{{ asset('storage/'.$sale->gambar_sales) }}" alt="gambar"
                                                class="w-8 h-8 rounded-full object-cover border mx-auto">
                                        </div>
                                    </td>
                                    <td class="px-2 py-2 text-left align-middle">{{ $sale->kode_sales }}</td>
                                    <td class="px-2 py-2 text-left align-middle">{{ $sale->nama_sales }}</td>
                                    <td class="px-2 py-2 text-left align-middle">{{ $sale->pelanggans_count }}</td>
                                    <td class="px-2 py-2 text-left align-middle">
                                        @php
                                            $target = 10; // Target default per sales
                                            $ach = $target > 0 ? round(($sale->pelanggans_count / $target) * 100, 1) : 0;
                                        @endphp
                                        {{ $ach }}%
                                    </td>
                                </tr>
                            @empty
                                <tr class="border-t hover:bg-gray-100 transition">
                                    <td class="px-2 py-2 text-center" colspan="6">Tidak Ada Data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Tombol Baca Selengkapnya --}}
                @if ($salesWithTarget->count() > 5)
                    <div class="text-center">
                        <button x-on:click="showAllSales = !showAllSales"
                            class="text-blue-600 hover:text-blue-800 font-medium text-sm transition">
                            <span x-text="showAllSales ? 'Tampilkan Lebih Sedikit' : 'Baca Selengkapnya'"></span>
                        </button>
                    </div>
                @endif
            </div>


            <!-- Ranking Sales Agency -->
            <div class="w-1/2 flex flex-col gap-4" x-data="{ showAllAgency: false }">
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
                            @forelse ($rankedAgencies as $index => $agency)
                                <tr x-show="{{ $loop->iteration }} <= 5 || showAllAgency" x-cloak
                                    class="border-t hover:bg-gray-100 transition">
                                    <td class="border px-2 py-2">{{ $agency->agency }}</td>
                                    <td class="border px-2 py-2">{{ $agency->total_target }}</td>
                                    <td class="border px-2 py-2">{{ $agency->total_realisasi }}</td>
                                    <td class="border px-2 py-2">{{ $agency->achievement }}%</td>
                                    <td class="border px-2 py-2">{{ $agency->rank }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="border px-2 py-2 text-center text-gray-500">
                                        Tidak ada data agency aktif.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Tombol Baca Selengkapnya --}}
                @if ($rankedAgencies->count() > 5)
                    <div class="text-center mt-2">
                        <button x-on:click="showAllAgency = !showAllAgency"
                            class="text-blue-600 hover:text-blue-800 font-medium text-sm transition">
                            <span x-text="showAllAgency ? 'Tampilkan Lebih Sedikit' : 'Baca Selengkapnya'"></span>
                        </button>
                    </div>
                @endif
            </div>
        </div>

        <div class="w-full grid grid-cols-1 sm:grid-cols-2 gap-10 ">
            <!-- Total PS Bulanan -->
            <div class="flex flex-col gap-4 shadow-md p-4 border-2 rounded-lg">
                <div class="flex justify-between pb-4 mb-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center">
                        <div>
                            <h5 class="leading-none text-xl font-bold text-gray-900 dark:text-white pb-1">
                                Total PS Bulanan
                            </h5>
                            <p class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                {{ \Carbon\Carbon::parse($startDate)->format('M d Y') }} -
                                {{ \Carbon\Carbon::parse($endDate)->format('M d Y') }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- 🔹 Tambahkan wrapper scroll -->
                <div class="overflow-x-auto">
                    <div id="column-chart" class="max-w-full"></div>
                </div>
            </div>

            <!-- Performance Telda Banyuwangi -->
            <div class="flex flex-col gap-4 shadow-md p-4 border-2 rounded-lg">
                <div class="max-w-sm w-full bg-white rounded-lg shadow-sm dark:bg-gray-800">
                    <div class="flex justify-between pb-4 mb-4 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-center">
                            <div>
                                <h5 class="leading-none text-xl font-bold text-gray-900 dark:text-white pb-1">
                                    Performance Telda Banyuwangi
                                </h5>
                                <p class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                    {{ \Carbon\Carbon::parse($startDate)->format('M d Y') }} -
                                    {{ \Carbon\Carbon::parse($endDate)->format('M d Y') }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div id="bar-chart"></div>
                </div>
            </div>
        </div>


        <div class="w-full">
            <div class="mb-4 bg-blue-600 p-4 rounded-xl font-bold text-white text-center">
                Data Detail Per Sales
                <p class="text-sm font-normal text-white opacity-80">
                    {{ \Carbon\Carbon::parse($startDate)->format('M d Y') }} -
                    {{ \Carbon\Carbon::parse($endDate)->format('M d Y') }}
                </p>
            </div>

            <div class="overflow-x-auto rounded-xl">
                <table class="min-w-full table-auto bg-white border border-gray-200 rounded text-sm">
                    <thead class="bg-blue-100 text-gray-700">
                        <tr>
                            <th class="border px-2 py-2 font-bold text-left align-middle">Nama Sales</th>
                            <th class="border px-2 py-2 font-bold text-left align-middle">Kode</th>
                            <th class="border px-2 py-2 font-bold text-left align-middle">Agency</th>
                            <th class="border px-2 py-2 font-bold text-left align-middle">Total Pelanggan</th>
                            <th class="border px-2 py-2 font-bold text-left align-middle">Indibiz</th>
                            <th class="border px-2 py-2 font-bold text-left align-middle">WMS</th>
                            <th class="border px-2 py-2 font-bold text-left align-middle">Netmonk</th>
                            <th class="border px-2 py-2 font-bold text-left align-middle">OCA</th>
                            <th class="border px-2 py-2 font-bold text-left align-middle">Antarez</th>
                            <th class="border px-2 py-2 font-bold text-left align-middle">Pijar Sekolah</th>
                            <th class="border px-2 py-2 font-bold text-left align-middle">Presentase</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600">
                        @forelse($salesWithTarget as $sale)
                            <tr class="border-t hover:bg-gray-100 transition">
                                <td class="px-2 py-2 text-left align-middle">{{ $sale->nama_sales }}</td>
                                <td class="px-2 py-2 text-left align-middle">{{ $sale->kode_sales }}</td>
                                <td class="px-2 py-2 text-left align-middle">{{ $sale->agency ?? '-' }}</td>
                                <td class="px-2 py-2 text-left align-middle">{{ $sale->pelanggan_count }}</td>

                                {{-- ACH% per produk --}}
                                <td class="px-2 py-2 text-left align-middle">
                                    {{ $sale->productAch['indibiz']['sk_result'] ?? 0 }} %
                                </td>
                                <td class="px-2 py-2 text-left align-middle">
                                    {{ $sale->productAch['wms']['sk_result'] ?? 0 }} %
                                </td>
                                <td class="px-2 py-2 text-left align-middle">
                                    {{ $sale->productAch['netmonk']['sk_result'] ?? 0 }} %
                                </td>
                                <td class="px-2 py-2 text-left align-middle">
                                    {{ $sale->productAch['oca']['sk_result'] ?? 0 }} %
                                </td>
                                <td class="px-2 py-2 text-left align-middle">
                                    {{ $sale->productAch['antarez']['sk_result'] ?? 0 }} %
                                </td>
                                <td class="px-2 py-2 text-left align-middle">
                                    {{ $sale->productAch['pijar_sekolah']['sk_result'] ?? 0 }} %
                                </td>

                                {{-- Total SK% --}}
                                <td class="px-2 py-2 text-left align-middle font-semibold text-blue-700">
                                    {{ $sale->total_target ?? 0 }} %
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="py-3 px-6 text-center text-gray-500">
                                    Tidak ada data
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>




        </div>

    </div>

    @push('scripts')
        <script>
            // Ambil data dari controller (contoh)
            const columnData = @json($chartData['column_data'] ?? []);

            // Hitung jumlah bulan
            const monthCount = columnData.length;

            // Dapatkan elemen chart
            const chartEl = document.getElementById('column-chart');

            // Jika bulan > 6, beri lebar dinamis agar bisa scroll
            if (monthCount > 6) {
                chartEl.style.minWidth = `${monthCount * 120}px`;
            } else {
                // Jika hanya sedikit bulan, biarkan mengikuti container (tidak scroll)
                chartEl.style.minWidth = '100%';
            }


            // Reset Button
            document.getElementById('reset-btn').addEventListener('click', function () {
                const startInput = document.getElementById('datepicker-range-start');
                const endInput = document.getElementById('datepicker-range-end');

                // Kembalikan ke default (awal dan akhir bulan sekarang)
                const now = new Date();
                const firstDay = new Date(now.getFullYear(), now.getMonth(), 1);
                const lastDay = new Date(now.getFullYear(), now.getMonth() + 1, 0);

                const formatDate = (date) => date.toISOString().split('T')[0];

                startInput.value = formatDate(firstDay);
                endInput.value = formatDate(lastDay);

                // Optional: otomatis submit setelah reset
                document.getElementById('date-form').submit();
            });
            // Auto submit form ketika tanggal berubah
            document.addEventListener('DOMContentLoaded', function () {
                const dateInputs = document.querySelectorAll('#datepicker-range-start, #datepicker-range-end');
                dateInputs.forEach(input => {
                    input.addEventListener('change', function () {
                        document.getElementById('date-form').submit();
                    });
                });
            });

            const columnOptions = {
                colors: ["#1A56DB"],
                series: [{
                    name: "Total Pelanggan",
                    color: "#1A56DB",
                    data: {!! json_encode($chartData['column_data']) !!}
                }],
                chart: {
                    type: "bar",
                    height: 320,
                    fontFamily: "Inter, sans-serif",
                    toolbar: { show: false },
                    parentHeightOffset: 0,
                    foreColor: "#333",
                    events: {
                        dataPointSelection: function (event, chartContext, config) {
                            event.stopPropagation(); // jangan bubble ke document click
                            const { seriesIndex, dataPointIndex, w } = config;
                            const data = w.globals.initialSeries[seriesIndex].data[dataPointIndex];
                            const pos = { x: event.clientX, y: event.clientY };
                            showCustomTooltip(data, seriesIndex, dataPointIndex, pos);
                        }
                    }
                },
                tooltip: { enabled: false },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: "70%",
                        borderRadiusApplication: "end",
                        borderRadius: 8,
                    },
                },
                states: { hover: { filter: { type: "darken", value: 1 } } },
                stroke: { show: true, width: 0, colors: ["transparent"] },
                grid: { show: false },
                dataLabels: { enabled: false },
                legend: { show: false },
                xaxis: {
                    labels: { show: true },
                    axisBorder: { show: false },
                    axisTicks: { show: false },
                },
                yaxis: { show: false },
                fill: { opacity: 1 },
            };


            // ===== Custom Tooltip =====
            function showCustomTooltip(data, seriesIndex, dataPointIndex, pos) {
                const items = data.detail.split(",").map(s => s.trim());
                const hasMore = items.length > 3;
                const tooltipId = `tooltip-${seriesIndex}-${dataPointIndex}`;
                const expanded = window.currentExpandedTooltip === tooltipId;
                const limit = expanded ? items.length : 3;

                let rows = "";
                for (let i = 0; i < limit && i < items.length; i++) {
                    const [name, value] = items[i].split(":");
                    rows += `<tr>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <td style='padding:4px;'>${i + 1}. ${name?.trim() || ""}</td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <td style='padding:4px; font-weight:600; text-align:right;'>${value?.trim() || ""}</td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </tr>`;
                }

                const label = expanded ? "Lihat lebih sedikit" : "Lihat lebih banyak";
                const button = hasMore
                    ? `<button id='${tooltipId}-btn' class="w-full text-blue-600 mt-4 text-center border-none p-2 text-sm cursor-pointer">${label}</button>`
                    : "";

                // Hapus tooltip lama
                const existing = document.getElementById("floating-tooltip");
                if (existing) existing.remove();

                // Buat elemen tooltip
                const tooltip = document.createElement("div");
                tooltip.id = "floating-tooltip";
                tooltip.style.position = "fixed"; // gunakan fixed agar stabil di viewport
                tooltip.style.pointerEvents = "auto";
                tooltip.style.zIndex = 999999;
                tooltip.style.background = "#fff";
                tooltip.style.border = "1px solid #ddd";
                tooltip.style.borderRadius = "8px";
                tooltip.style.boxShadow = "0 2px 10px rgba(0,0,0,0.15)";
                tooltip.style.padding = "8px";
                tooltip.style.fontSize = "12px";
                tooltip.style.minWidth = "200px";

                tooltip.innerHTML = `
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <div style='font-weight:600;margin-bottom:4px;border-bottom:1px solid #ddd;padding-bottom:4px;'>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          Pencapaian Poin Sales - ${data.x}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <div style='margin-bottom:6px;'>Total: <b>${data.y}</b></div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <table><tbody>${rows}</tbody></table>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        ${button}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      `;

                // Posisi tooltip (menyesuaikan agar tidak keluar layar)
                const offsetX = 20, offsetY = 15;
                let left = pos.x + offsetX;
                let top = pos.y + offsetY;
                const tooltipWidth = 220;
                const tooltipHeight = 200;
                if (left + tooltipWidth > window.innerWidth) left = window.innerWidth - tooltipWidth - 10;
                if (top + tooltipHeight > window.innerHeight) top = window.innerHeight - tooltipHeight - 10;

                tooltip.style.left = left + "px";
                tooltip.style.top = top + "px";

                tooltip.addEventListener("click", (e) => e.stopPropagation());
                document.body.appendChild(tooltip);

                // Tombol "lebih banyak"
                const btn = document.getElementById(`${tooltipId}-btn`);
                if (btn) {
                    btn.onclick = (ev) => {
                        ev.stopPropagation();
                        window.currentExpandedTooltip = expanded ? null : tooltipId;
                        showCustomTooltip(data, seriesIndex, dataPointIndex, pos);
                    };
                }

                // Tutup tooltip saat klik di luar
                const handleOutsideClick = (e) => {
                    if (!tooltip.contains(e.target)) {
                        tooltip.remove();
                        window.removeEventListener("click", handleOutsideClick);
                    }
                };

                // Delay agar event click bar tidak ikut dianggap “klik di luar”
                setTimeout(() => {
                    window.addEventListener("click", handleOutsideClick);
                }, 100);
            }

            if (document.getElementById("column-chart") && typeof ApexCharts !== 'undefined') {
                const chart = new ApexCharts(document.getElementById("column-chart"), columnOptions);
                chart.render();
            }

            // Bar Chart Configuration
            const realisasi = @json($chartData['bar_realisasi']);;
            const targets = @json($chartData['bar_target']);
            const categories = @json($chartData['bar_labels']);

            const percentages = realisasi.map(
                (p, i) => ((p / targets[i]) * 100).toFixed(1) + "%"
            );

            const barOptions = {
                series: [
                    {
                        name: "Achievement",
                        color: "#1A56DB",
                        data: realisasi,
                    },
                    {
                        name: "Target",
                        color: "#92c0f4",
                        data: targets,
                    },
                ],
                chart: {
                    type: "bar",
                    stacked: true,
                    height: 400,
                    events: {
                        rendered: function (chartCtx) {
                            // hapus label lama
                            const existing = chartCtx.el.querySelectorAll(".percent-label");
                            existing.forEach((el) => el.remove());

                            // ambil semua bar (rect/path) dari series Achievement
                            const bars =
                                chartCtx.el.querySelectorAll(
                                    ".apexcharts-bar-series.apexcharts-series-0 .apexcharts-bar-area, " +
                                    ".apexcharts-bar-series.apexcharts-series-0 path, " +
                                    ".apexcharts-bar-series.apexcharts-series-0 rect"
                                );

                            bars.forEach((bar, i) => {
                                const rect = bar.getBoundingClientRect();
                                const chartRect = chartCtx.el.getBoundingClientRect();

                                const label = document.createElement("span");
                                label.classList.add("percent-label");
                                label.innerText = percentages[i];
                                label.style.position = "absolute";
                                label.style.left =
                                    rect.right - chartRect.left + 10 + "px"; // geser ke kanan
                                label.style.top =
                                    rect.top - chartRect.top + rect.height / 2 - 8 + "px";
                                label.style.fontSize = "12px";
                                label.style.fontWeight = "600";
                                label.style.color = "#111827";

                                chartCtx.el.appendChild(label);
                            });
                        },
                    },
                },
                plotOptions: {
                    bar: {
                        horizontal: true,
                        borderRadiusApplication: "end",
                        borderRadius: 6,
                    },
                },
                dataLabels: {
                    enabled: true,
                    formatter: function (val, opts) {
                        // tampilkan angka untuk kedua series
                        return val;
                    },
                    style: {
                        colors: ["#fff", "#111827"], // putih untuk achievement, hitam untuk target
                        fontWeight: 600,
                    },
                },
                legend: {
                    show: true,
                    position: "top",
                },
                tooltip: {
                    shared: true,
                    intersect: false,
                },
                xaxis: {
                    categories: categories,
                },
                grid: {
                    show: true,
                    strokeDashArray: 4,
                },
            };

            if (document.getElementById("bar-chart") && typeof ApexCharts !== "undefined") {
                const chart = new ApexCharts(document.getElementById("bar-chart"), barOptions);
                chart.render();
            }
        </script>
    @endpush
@endsection