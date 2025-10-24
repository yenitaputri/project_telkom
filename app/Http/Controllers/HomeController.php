<?php

namespace App\Http\Controllers;

use App\Models\Astinet;
use Illuminate\Http\Request;
use App\Models\Sales;
use App\Models\Pelanggan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        try {
            $startDate = $request->get('start')
                ? Carbon::parse($request->get('start'))->startOfDay()
                : Carbon::now()->startOfMonth();

            $endDate = $request->get('end')
                ? Carbon::parse($request->get('end'))->endOfDay()
                : Carbon::now()->endOfMonth();
        } catch (\Exception $e) {
            $startDate = Carbon::now()->startOfMonth();
            $endDate = Carbon::now()->endOfMonth();
        }

        // Ambil data sales beserta total pelanggan (realisasi)
        $sales = Sales::withCount([
            'pelanggans as pelanggans_count' => fn ($q) =>
                $q->whereBetween('tanggal_ps', [$startDate, $endDate])
        ])->get();

        // Data pelanggan dengan filter tanggal
        $pelanggan = Pelanggan::whereBetween('tanggal_ps', [$startDate, $endDate])->get();

        // Total Astinet
        $astinet = Astinet::sum('bandwidth');

        // === Target Agency Bulanan ===
        $targetAgency = DB::table('targets')
            ->where('target_type', 'agency')
            ->whereBetween('tahun', [$startDate->year, $endDate->year])
            ->when($startDate->month != $endDate->month, function ($q) use ($startDate, $endDate) {
                $q->whereBetween('bulan', [$startDate->month, $endDate->month]);
            })
            ->get()
            ->keyBy(fn ($item) => $item->target_ref.'-'.$item->tahun.'-'.$item->bulan);

        // === Agency Achievement ===
        $agencies = DB::table('sales')
            ->join('pelanggan', 'pelanggan.kode_sales', '=', 'sales.kode_sales')
            ->leftJoin('targets', function ($join) use ($startDate, $endDate) {
                $join->on('targets.target_ref', '=', 'sales.agency')
                    ->where('targets.target_type', '=', 'agency')
                    ->where(function ($q) use ($startDate, $endDate) {
                        $q->where('targets.tahun', '>', $startDate->year)
                            ->where('targets.tahun', '<', $endDate->year)
                            ->orWhere(function ($sub) use ($startDate, $endDate) {
                                $sub->where('targets.tahun', '=', $startDate->year)
                                    ->where('targets.bulan', '>=', $startDate->month);
                            })
                            ->orWhere(function ($sub) use ($startDate, $endDate) {
                                $sub->where('targets.tahun', '=', $endDate->year)
                                    ->where('targets.bulan', '<=', $endDate->month);
                            });
                    });
            })
            ->select(
                'sales.agency',
                DB::raw('COUNT(DISTINCT pelanggan.kode_sales) as total_realisasi'),
                DB::raw('COALESCE(SUM(targets.target_value), 0) as total_target'),
                DB::raw('ROUND((COUNT(DISTINCT pelanggan.kode_sales) / NULLIF(SUM(targets.target_value), 0)) * 100, 2) as achievement'),
            )
            ->whereBetween('pelanggan.tanggal_ps', [$startDate, $endDate])
            ->groupBy('sales.agency')
            ->orderByDesc('achievement')
            ->get();


        $agencies = $agencies->map(function ($item) use ($targetAgency, $startDate) {
            $key = $item->agency.'-'.$startDate->year.'-'.$startDate->month;
            $item->total_target = $targetAgency[$key]->target_value ?? 0;
            $item->achievement = $item->total_target > 0
                ? round(($item->total_realisasi / $item->total_target) * 100, 2)
                : 0;
            return $item;
        });

        // === Ranking berdasarkan achievement tertinggi ===
        $rankedAgencies = $agencies
            ->sortByDesc(function ($item) {
                // urutkan berdasarkan achievement, jika sama urutkan berdasarkan total_realisasi
                return [$item->achievement, $item->total_realisasi];
            })
            ->values()
            ->map(function ($item, $index) {
                $item->rank = $index + 1;
                return $item;
            });

        // === Target Sales Tahunan ===
        $targetSales = DB::table('targets')
            ->where('target_type', 'sales')
            ->where('tahun', $startDate->year)
            ->get()
            ->keyBy(fn ($item) => $item->target_ref.'-'.$item->tahun);

        // === Sales Achievement ===
        $salesWithTarget = $sales->map(function ($item) use ($targetSales, $startDate) {
            $key = $item->kode_sales.'-'.$startDate->year;
            $item->total_target = $targetSales[$key]->target_value ?? 0;
            $item->achievement = $item->total_target > 0
                ? round(($item->pelanggans_count / $item->total_target) * 100, 2)
                : 0;
            return $item;
        });

        // === Chart Data ===
        $chartData = $this->getChartData($startDate, $endDate);

        return view('home.index', compact(
            'salesWithTarget',
            'pelanggan',
            'astinet',
            'rankedAgencies',
            'chartData',
            'startDate',
            'endDate',
        ));
    }


    private function getAgencyData($startDate, $endDate)
    {
        // Query untuk data agency
        $agencyData = DB::table('sales')
            ->leftJoin('pelanggan', function ($join) use ($startDate, $endDate) {
                $join->on('sales.kode_sales', '=', 'pelanggan.kode_sales')
                    ->whereBetween('pelanggan.created_at', [$startDate, $endDate]);
            })
            ->select(
                'sales.agency',
                DB::raw('COUNT(pelanggan.id) as total_pelanggan'),
                DB::raw('COALESCE(SUM(pelanggan.target), 0) as total_target'),
                DB::raw('COALESCE(SUM(pelanggan.realisasi), 0) as total_realisasi'),
            )
            ->whereNotNull('sales.agency')
            ->groupBy('sales.agency')
            ->get()
            ->map(function ($item, $index) {
                $ach = $item->total_target > 0
                    ? round(($item->total_realisasi / $item->total_target) * 100, 2)
                    : 0;

                return [
                    'agency' => $item->agency,
                    'target' => number_format($item->total_target),
                    'realisasi' => number_format($item->total_realisasi),
                    'ach' => $ach.'%',
                    'rank' => $index + 1,
                    'total_pelanggan' => $item->total_pelanggan
                ];
            })
            ->sortByDesc('total_realisasi')
            ->values()
            ->toArray();

        return $agencyData;
    }

    private function getChartData($startDate, $endDate)
    {
        try {
            $start = $startDate->copy()->startOfMonth();
            $end = $endDate->copy()->endOfMonth();

            // 🔹 Ambil data untuk masing-masing chart
            $columnData = $this->getColumnChartData($start, $end);
            // $columnData = $this->getColumnChartDataDummy($start, $end);
            $barData = $this->getProdigiBarData($start, $end);

            return [
                'column_data' => $columnData,
                'bar_labels' => $barData['labels'] ?? [],
                'bar_realisasi' => $barData['realisasi'],
                'bar_target' => $barData['target'],
            ];
        } catch (\Exception $e) {
            \Log::error('Error in getChartData: '.$e->getMessage());

            return [
                'column_data' => $columnData,
                'bar_labels' => $barData['labels'] ?? [],
                'bar_realisasi' => [0, 0, 0, 0],
                'bar_target' => [0, 0, 0, 0],
            ];
        }
    }

    private function getColumnChartData($start, $end)
    {
        // Ambil data dari database dalam rentang tanggal
        $monthlyData = $this->fetchMonthlyData($start->format('Y-m-d'), $end->format('Y-m-d'), 'tanggal_ps');

        // Kelompokkan data berdasarkan bulan (YYYY-MM)
        $groupedData = $monthlyData->groupBy(fn ($item) => sprintf('%d-%02d', $item->year, $item->month));

        // 🔹 Buat daftar semua bulan dalam range
        $monthsRange = collect();
        $current = $start->copy();
        while ($current->lte($end)) {
            $monthsRange->push([
                'year' => $current->year,
                'month' => $current->month,
                'key' => sprintf('%d-%02d', $current->year, $current->month),
                'label' => $current->format('M Y'),
            ]);
            $current->addMonth();
        }

        // 🔹 Gabungkan data dari DB dan isi bulan kosong dengan 0
        $columnData = $monthsRange->map(function ($m) use ($groupedData) {
            $monthData = $groupedData->get($m['key']);

            if ($monthData) {
                $total = $monthData->sum('total_per_sales');
                $details = $monthData->map(fn ($salesData) =>
                    "{$salesData->nama_sales}: {$salesData->total_per_sales}"
                )->implode(', ');
            } else {
                $total = 0;
                $details = '';
            }

            return [
                'x' => $m['label'], // contoh: "Jan 2025"
                'y' => $total,
                'detail' => $details,
                'year' => $m['year'],
                'month' => $m['month'],
            ];
        });

        // 🔹 Fallback jika tidak ada data sama sekali
        if ($columnData->isEmpty()) {
            $columnData = collect([[
                'x' => Carbon::now()->format('M Y'),
                'y' => 0,
                'detail' => '',
                'year' => Carbon::now()->year,
                'month' => Carbon::now()->month,
            ]]);
        }

        return $columnData->values();
    }


    private function getProdigiBarData($start, $end)
    {
        // 🔹 Ambil daftar produk berdasarkan target_ref yang ada di tabel targets (tipe prodigi)
        $products = DB::table('targets')
            ->where('target_type', 'prodigi')
            ->distinct()
            ->pluck('target_ref')
            ->toArray();

        // 🔹 Ambil data realisasi per paket
        $prodigiData = DB::table('prodigi')
            ->select(
                'paket',
                DB::raw('COALESCE(COUNT(*), 0) AS total_realisasi'),
            )
            ->whereBetween('tanggal_ps', [$start, $end])
            ->whereIn('paket', $products)
            ->groupBy('paket')
            ->get()
            ->keyBy('paket');

        // 🔹 Ambil target prodigi per bulan dalam range
        $targetProdigi = DB::table('targets')
            ->where('target_type', 'prodigi')
            ->where(function ($q) use ($start, $end) {
                // Jika start & end berbeda tahun
                if ($start->year != $end->year) {
                    $q->where(function ($q2) use ($start) {
                        $q2->where('tahun', $start->year)->where('bulan', '>=', $start->month);
                    });
                    $q->orWhere(function ($q2) use ($end) {
                        $q2->where('tahun', $end->year)->where('bulan', '<=', $end->month);
                    });
                } else {
                    // Sama tahun
                    $q->where('tahun', $start->year)
                        ->whereBetween('bulan', [$start->month, $end->month]);
                }
            })
            ->get();

        $target = [];
        $realisasi = [];

        foreach ($products as $p) {
            // 🔹 Jumlahkan target semua bulan untuk produk ini
            $t = $targetProdigi->where('target_ref', $p)->sum('target_value');
            $r = $prodigiData->get($p) ? (int) $prodigiData->get($p)->total_realisasi : 0;

            $target[] = $t;
            $realisasi[] = $r;
        }

        return [
            'labels' => $products,
            'target' => $target,
            'realisasi' => $realisasi,
        ];
    }

    /**
     * Helper untuk ambil data bulanan
     */
    private function fetchMonthlyData($start, $end, $dateField)
    {
        return DB::table('pelanggan')
            ->join('sales', 'pelanggan.kode_sales', '=', 'sales.kode_sales')
            ->whereBetween("pelanggan.$dateField", [$start, $end])
            ->select(
                DB::raw("MONTH(pelanggan.$dateField) as month"),
                DB::raw("YEAR(pelanggan.$dateField) as year"),
                'sales.nama_sales',
                DB::raw('COUNT(pelanggan.id) as total_per_sales'),
            )
            ->groupBy('year', 'month', 'sales.nama_sales')
            ->orderBy('year')
            ->orderBy('month')
            ->get();
    }
}