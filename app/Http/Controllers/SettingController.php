<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use App\Models\Target;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view('settings.index');
    }

    public function salesIndex(Request $request)
    {
        $sales = Sales::all();
        $tahun = $request->input('tahun', now()->year);
        $bulan = $request->input('bulan', ''); // <-- pastikan selalu tersedia (boleh kosong)

        $targetSales = Target::where('target_type', 'sales')
            ->when(! empty($tahun), fn ($q) => $q->where('tahun', $tahun))
            ->orderBy('tahun', 'desc')
            ->get();

        return view('target.sales', compact('targetSales', 'tahun', 'bulan', 'sales'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
