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
        // Validasi dan format tanggal
        try {
            $startDate = $request->get('start')
                ? Carbon::parse($request->get('start'))->startOfDay()
                : Carbon::now()->startOfMonth();

            $endDate = $request->get('end')
                ? Carbon::parse($request->get('end'))->endOfDay()
                : Carbon::now()->endOfMonth();
        } catch (\Exception $e) {
            // Jika parsing gagal, gunakan default
            $startDate = Carbon::now()->startOfMonth();
            $endDate = Carbon::now()->endOfMonth();
        }

        $sales = Sales::withCount([
            'pelanggans as pelanggans_count' => fn ($q) =>
                $q->whereBetween('tanggal_ps', [$startDate, $endDate])
        ])->get();

        // Data pelanggan dengan filter tanggal
        $pelanggan = Pelanggan::whereBetween('tanggal_ps', [$startDate, $endDate])->get();

        // Total Astinet
        $astinet = Astinet::all();

        // // Data agency dengan filter tanggal
        $targetAgency = DB::table('targets')
            ->where('target_type', 'agency')
            ->whereBetween('tahun', [$startDate->year, $endDate->year])
            ->when($startDate->month != $endDate->month, function ($q) use ($startDate, $endDate) {
                $q->whereBetween('bulan', [$startDate->month, $endDate->month]);
            })
            ->get()
            ->keyBy(function ($item) {
                return $item->target_ref.'-'.$item->tahun.'-'.$item->bulan;
            });

        $agencies = DB::table('sales')
            ->join('pelanggan', 'pelanggan.kode_sales', '=', 'sales.kode_sales')
            ->select(
                'sales.agency',
                DB::raw('NULL as total_target'),
                DB::raw('COUNT(pelanggan.kode_sales) as total_realisasi'),
                DB::raw('ROUND(COUNT(pelanggan.kode_sales) * 100.0 / 
                (SELECT COUNT(*) FROM pelanggan), 2) as achievement'),
            )
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


        $rankedAgencies = $agencies->map(function ($item, $index) {
            $item->rank = $index + 1;
            return $item;
        });



        // // Data untuk chart
        $chartData = $this->getChartData($startDate, $endDate);
        // return dd($chartData);

        return view('home.index', compact(
            'sales',
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
            $barData = $this->getProdigiBarData($start, $end);

            return [
                'column_data' => $columnData,
                'bar_realisasi' => $barData['realisasi'],
                'bar_target' => $barData['target'],
            ];
        } catch (\Exception $e) {
            \Log::error('Error in getChartData: '.$e->getMessage());

            return [
                'column_data' => $columnData,
                'bar_realisasi' => [0, 0, 0, 0],
                'bar_target' => [0, 0, 0, 0],
            ];
        }
    }

    private function getColumnChartData($start, $end)
    {
        // Ambil data dengan field tanggal tertentu
        $monthlyData = $this->fetchMonthlyData($start->format('Y-m-d'), $end->format('Y-m-d'), 'tanggal_ps');

        // Kelompokkan data per bulan (YYYY-MM)
        $groupedData = $monthlyData->groupBy(fn ($item) => sprintf('%d-%02d', $item->year, $item->month));

        $columnData = $groupedData->map(function ($monthData) {
            $firstItem = $monthData->first();
            $monthName = Carbon::create()->month($firstItem->month)->format('M');
            $total = $monthData->sum('total_per_sales');

            $details = $monthData->map(fn ($salesData) =>
                "{$salesData->nama_sales}: {$salesData->total_per_sales}"
            )->implode(', ');

            return [
                'x' => $monthName,
                'y' => $total,
                'detail' => $details,
                'year' => $firstItem->year,
                'month' => $firstItem->month,
            ];
        })->values();

        // Jika kosong, fallback ke sample data
        if ($columnData->isEmpty()) {
            $columnData = collect([[
                'x' => Carbon::now()->format('M y'),
                'y' => 0,
                'detail' => '',
                'year' => Carbon::now()->year,
                'month' => Carbon::now()->month,
            ]]);
        }

        return $columnData;
    }

    private function getProdigiBarData($start, $end)
    {
        $products = ['NETMONK', 'OCA', 'Antarez', 'Pijar Sekolah'];

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