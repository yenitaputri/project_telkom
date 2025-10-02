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
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                </svg>
                            </div>
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
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                </svg>
                            </div>
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
                        Filter
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
                                <th class="border px-2 py-2 font-bold text-left align-middle">Total Pelanggan</th>
                                <th class="border px-2 py-2 font-bold text-left align-middle">ACH</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600">
                            @foreach ($sales->sortByDesc('pelanggans_count') as $index => $sale)
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
                                    <td class="px-2 py-2 text-left align-middle ">
                                        {{ $sale->pelanggans_count }}
                                    </td>
                                    <td class="px-2 py-2 text-left align-middle">
                                        @php
                                            $target = 10; // Target default per sales
                                            $ach = $target > 0 ? round(($sale->pelanggans_count / $target) * 100, 1) : 0;
                                        @endphp
                                        {{ $ach }}%
                                    </td>
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

        <div class="w-full flex gap-10 justify-between">
            <!-- Total PS Bulanan -->
            <div class="w-1/2 flex flex-col gap-4 shadow-md p-4 border-2 rounded-lg">
                <div class="flex justify-between pb-4 mb-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center">
                        <div>
                            <h5 class="leading-none text-xl font-bold text-gray-900 dark:text-white pb-1">Total PS Bulanan
                            </h5>
                            <p class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                {{ \Carbon\Carbon::parse($startDate)->format('M d') }} -
                                {{ \Carbon\Carbon::parse($endDate)->format('M d') }}
                            </p>
                        </div>
                    </div>
                </div>
                <div id="column-chart"></div>
            </div>

            <!-- Performance Telda Banyuwangi -->
            <div class="w-1/2 flex flex-col gap-4 shadow-md p-4 border-2 rounded-lg">
                <div class="max-w-sm w-full bg-white rounded-lg shadow-sm dark:bg-gray-800">
                    <div class="flex justify-between pb-4 mb-4 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-center">
                            <div>
                                <h5 class="leading-none text-xl font-bold text-gray-900 dark:text-white pb-1">
                                    Performance Telda Banyuwangi
                                </h5>
                                <p class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                    {{ \Carbon\Carbon::parse($startDate)->format('M d') }} -
                                    {{ \Carbon\Carbon::parse($endDate)->format('M d') }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div id="bar-chart"></div>
                </div>
            </div>
        </div>

        <div class="w-full">
            <div class="mb-4 bg-blue-600 p-4 rounded-xl font-bold text-white text-center">Data Detail Per Sales</div>
            <div class="overflow-x-auto rounded-xl">
                <table class="min-w-full table-auto bg-white border border-gray-200 rounded text-sm">
                    <thead class="bg-blue-100 text-gray-700">
                        <tr>
                            <th class="border px-2 py-2 font-bold text-left align-middle">Nama Sales</th>
                            <th class="border px-2 py-2 font-bold text-left align-middle">Kode</th>
                            <th class="border px-2 py-2 font-bold text-left align-middle">Agency</th>
                            <th class="border px-2 py-2 font-bold text-left align-middle">Total Pelanggan</th>
                            <th class="border px-2 py-2 font-bold text-left align-middle">Total Indibiz</th>
                            <th class="border px-2 py-2 font-bold text-left align-middle">Total WMS</th>
                            <th class="border px-2 py-2 font-bold text-left align-middle">Netmonk</th>
                            <th class="border px-2 py-2 font-bold text-left align-middle">OCA</th>
                            <th class="border px-2 py-2 font-bold text-left align-middle">Antarez</th>
                            <th class="border px-2 py-2 font-bold text-left align-middle">Pijar Sekolah</th>
                            <th class="border px-2 py-2 font-bold text-left align-middle">Presentase</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600">
                        @forelse($sales as $sale)
                            <tr class="border-t hover:bg-gray-100 transition">
                                <td class="px-2 py-2 text-left align-middle">{{ $sale->nama_sales }}</td>
                                <td class="px-2 py-2 text-left align-middle">{{ $sale->kode_sales }}</td>
                                <td class="px-2 py-2 text-left align-middle">{{ $sale->agency ?? '-' }}</td>
                                <td class="px-2 py-2 text-left align-middle">
                                    {{ $sale->pelanggans_count }}
                                </td>
                                <td class="px-2 py-2 text-left align-middle">
                                    {{ $sale->pelanggans->where('produk', 'Indibiz')->count() }}
                                </td>
                                <td class="px-2 py-2 text-left align-middle">
                                    {{ $sale->pelanggans->where('produk', 'WMS')->count() }}
                                </td>
                                <td class="px-2 py-2 text-left align-middle">
                                    {{ $sale->pelanggans->where('produk', 'Netmonk')->count() }}
                                </td>
                                <td class="px-2 py-2 text-left align-middle">
                                    {{ $sale->pelanggans->where('produk', 'OCA')->count() }}
                                </td>
                                <td class="px-2 py-2 text-left align-middle">
                                    {{ $sale->pelanggans->where('produk', 'Antarez')->count() }}
                                </td>
                                <td class="px-2 py-2 text-left align-middle">
                                    {{ $sale->pelanggans->where('produk', 'Pijar Sekolah')->count() }}
                                </td>
                                <td class="px-2 py-2 text-left align-middle">
                                    @php
                                        $target = 10; // Target default
                                        $ach = $target > 0 ? round(($sale->pelanggans_count / $target) * 100, 1) : 0;
                                    @endphp
                                    {{ $ach }}%
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
            // Auto submit form ketika tanggal berubah
            document.addEventListener('DOMContentLoaded', function () {
                const dateInputs = document.querySelectorAll('#datepicker-range-start, #datepicker-range-end');
                dateInputs.forEach(input => {
                    input.addEventListener('change', function () {
                        document.getElementById('date-form').submit();
                    });
                });
            });

            // Column Chart Configuration
            const columnOptions = {
                colors: ["#1A56DB"],
                series: [{
                    name: "Total Pelanggan",
                    color: "#1A56DB",
                    data: {!! json_encode($chartData['column_data']) !!}
                }],
                chart: {
                    type: "bar",
                    height: "320px",
                    fontFamily: "Inter, sans-serif",
                    toolbar: { show: false },
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: "70%",
                        borderRadiusApplication: "end",
                        borderRadius: 8,
                    },
                },
                tooltip: {
                    custom: function ({ series, seriesIndex, dataPointIndex, w }) {
                        const data = w.globals.initialSeries[seriesIndex].data[dataPointIndex];

                        // pecah string "Riza: 80, Yenita: 40" -> ["Riza: 80", "Yenita: 40"]
                        const items = data.detail.split(",").map((s) => s.trim());

                        // buat baris tabel
                        let rows = "";
                        items.forEach((item, idx) => {
                            const [name, value] = item.split(":").map((s) => s.trim());
                            rows += `
                                                                                        <tr>
                                                                                          <td style="padding:4px;">${idx + 1}.  ${name}</td>
                                                                                          <td style="padding:4px; font-weight:600; text-align:right;">${value}</td>
                                                                                        </tr>
                                                                                      `;
                        });

                        return `
                                                                                      <div style="padding:8px; font-size:12px; min-width:200px;">
                                                                                        <div style="font-weight:600; margin-bottom:4px; border-bottom:1px solid #ddd; padding-bottom:4px;">
                                                                                          Pencapaian Poin Sales - ${data.x}
                                                                                        </div>
                                                                                        <div style="margin-bottom:6px;">Total: <b>${data.y}</b></div>
                                                                                        <table>
                                                                                          <tbody>
                                                                                            ${rows}
                                                                                          </tbody>
                                                                                        </table>
                                                                                      </div>
                                                                                    `;
                    },
                },
                states: {
                    hover: {
                        filter: { type: "darken", value: 1 },
                    },
                },
                stroke: {
                    show: true,
                    width: 0,
                    colors: ["transparent"],
                },
                grid: {
                    show: false,
                    strokeDashArray: 4,
                    padding: { left: 2, right: 2, top: -14 },
                },
                dataLabels: { enabled: false },
                legend: { show: false },
                xaxis: {
                    floating: false,
                    labels: {
                        show: true,
                        style: {
                            fontFamily: "Inter, sans-serif",
                            cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400'
                        }
                    },
                    axisBorder: { show: false },
                    axisTicks: { show: false },
                },
                yaxis: { show: false },
                fill: { opacity: 1 },
            };

            if (document.getElementById("column-chart") && typeof ApexCharts !== 'undefined') {
                const chart = new ApexCharts(document.getElementById("column-chart"), columnOptions);
                chart.render();
            }

            // Bar Chart Configuration
            const achievements = [25, 25, 25, 35];
            const targets = [50, 40, 50, 40];
            const categories = ["Netmonk", "Oca", "Antarez", "Pijar Sekolah"];

            const percentages = achievements.map(
                (p, i) => ((p / targets[i]) * 100).toFixed(1) + "%"
            );

            const barOptions = {
                series: [
                    {
                        name: "Achievement",
                        color: "#1A56DB",
                        data: achievements,
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