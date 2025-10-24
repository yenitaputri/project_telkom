<?php

namespace App\Http\Controllers;

use App\Models\Astinet;
use Illuminate\Http\Request;
use App\Models\Sales;
use App\Models\Pelanggan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Print_;

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
                    ->whereBetween(DB::raw("CONCAT(targets.tahun, LPAD(targets.bulan, 2, '0'))"), [
                        $startDate->format('Ym'),
                        $endDate->format('Ym')
                    ]);
            })
            ->select(
                'sales.agency',
                DB::raw('COUNT(pelanggan.id) as total_realisasi'),
                DB::raw('COALESCE(SUM(targets.target_value), 0) as total_target'),
                DB::raw('ROUND((COUNT(pelanggan.id) / NULLIF(SUM(targets.target_value), 0)) * 100, 2) as achievement'),
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

        // Ambil semua target sales product tahunan
        $targets = DB::table('sales_product_targets')
            ->where('tahun', $startDate->year)
            ->get();

        // === Sales Achievement berdasarkan Sales Product Target ====
        $salesWithTarget = $sales->map(function ($salesItem) use ($targets, $startDate, $endDate) {
            $totalSkPercent = 0;

            // Filter pelanggan sesuai bulan yang dipilih
            $filteredPelanggan = $salesItem->pelanggans->filter(function ($p) use ($startDate, $endDate) {
                if (! $p->tanggal_ps)
                    return false;

                $tanggal = \Carbon\Carbon::parse($p->tanggal_ps);
                return $tanggal->between($startDate, $endDate);
            });

            foreach ($targets as $target) {
                $product = strtolower($target->product);

                $realisasi = match ($product) {
                    'indibiz' => $filteredPelanggan->where('jenis_layanan', 'ilike', 'indibiz')->count(),
                    'wms' => $filteredPelanggan->filter(fn ($p) => str_contains(strtolower(optional($p->prodigi)->paket), 'wms'))->count(),
                    'netmonk' => $filteredPelanggan->where('cek_netmonk', 1)->count(),
                    'oca' => $filteredPelanggan->where('cek_oca', 1)->count(),
                    'antarez' => $filteredPelanggan->filter(fn ($p) => str_contains(strtolower(optional($p->prodigi)->paket), 'antarez'))->count(),
                    'pijar sekolah' => $filteredPelanggan->where('cek_pijar_sekolah', 1)->count(),
                    default => 0,
                };

                $achPercent = $target->ach > 0
                    ? min(($realisasi / $target->ach) * 100, 120)
                    : 0;

                $skPercent = ($achPercent * $target->sk) / 100;

                $totalSkPercent += $skPercent;
            }

            $salesItem->total_target = $totalSkPercent;
            return $salesItem;
        });

        return dd($salesWithTarget);

        // === Chart Data ===
        $chartData = $this->getChartData($startDate, $endDate);

        // return dd($chartData);

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
        // 🔹 Ambil daftar target prodigi dalam range tanggal
        $targetProdigi = DB::table('targets')
            ->where('target_type', 'prodigi')
            ->where(function ($q) use ($start, $end) {
                if ($start->year != $end->year) {
                    $q->where(function ($q2) use ($start) {
                        $q2->where('tahun', $start->year)->where('bulan', '>=', $start->month);
                    });
                    $q->orWhere(function ($q2) use ($end) {
                        $q2->where('tahun', $end->year)->where('bulan', '<=', $end->month);
                    });
                } else {
                    $q->where('tahun', $start->year)
                        ->whereBetween('bulan', [$start->month, $end->month]);
                }
            })
            ->get();

        // 🔹 Ambil produk dari target yang ada di periode (jika tidak ada -> kosong)
        $targetProducts = $targetProdigi->pluck('target_ref')->unique()->toArray();

        // 🔹 Ambil data realisasi prodigi per paket (hanya dalam range)
        $prodigiData = DB::table('prodigi')
            ->select(
                'paket',
                DB::raw('COUNT(*) AS total_realisasi'),
            )
            ->whereBetween('tanggal_ps', [$start, $end])
            ->groupBy('paket')
            ->get()
            ->keyBy('paket');

        // 🔹 Ambil semua produk yang muncul baik di target maupun realisasi
        $allProducts = collect(array_unique(array_merge(
            $targetProducts,
            $prodigiData->keys()->toArray(),
        )))->values();

        // 🔹 Jika tidak ada produk sama sekali, kembalikan data kosong
        if ($allProducts->isEmpty()) {
            return [
                'labels' => [],
                'target' => [],
                'realisasi' => [],
            ];
        }

        $target = [];
        $realisasi = [];

        foreach ($allProducts as $p) {
            $t = $targetProdigi->where('target_ref', $p)->sum('target_value');
            $r = $prodigiData->get($p) ? (int) $prodigiData->get($p)->total_realisasi : 0;

            $target[] = $t;
            $realisasi[] = $r;
        }

        return [
            'labels' => $allProducts,
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