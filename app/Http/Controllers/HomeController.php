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

        $rankedAgencies = $agencies->map(function ($item, $index) {
            $item->rank = $index + 1;
            return $item;
        });



        // // Data untuk chart
        $chartData = $this->getChartData($startDate, $endDate);
        // return dd($chartData['bar_achievement']);

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
            $start = $startDate->format('Y-m-d');
            $end = $endDate->format('Y-m-d');

            \Log::info("Querying chart data from {$start} to {$end}");

            // Ambil data dengan field tanggal tertentu
            $monthlyData = $this->fetchMonthlyData($start, $end, 'tanggal_ps');

            \Log::info('Monthly Data Count:', ['count' => $monthlyData->count()]);
            \Log::info('Sample Monthly Data:', $monthlyData->take(3)->toArray());

            // Kelompokkan data per bulan
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
                \Log::info('No data found, using sample data');
                $columnData = collect([[
                    'x' => Carbon::now()->format('M y'),
                    'y' => 0,
                    'detail' => '',
                    'year' => Carbon::now()->year,
                    'month' => Carbon::now()->month,
                ]]);
            }

            return [
                'column_data' => $columnData,
                'bar_achievement' => [25, 10, 25, 35],
                'bar_target' => [50, 100, 50, 40],
            ];
        } catch (\Exception $e) {
            \Log::error('Error in getChartData: '.$e->getMessage());

            return [
                'column_data' => [[
                    'x' => Carbon::now()->format('M'),
                    'y' => 0,
                    'detail' => '',
                    'year' => Carbon::now()->year,
                    'month' => Carbon::now()->month,
                ]],
                'bar_achievement' => [25, 100, 25, 35],
                'bar_target' => [50, 40, 50, 40],
            ];
        }
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