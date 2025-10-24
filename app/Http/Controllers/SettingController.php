<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use App\Models\SalesProductTarget;
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

        // Ambil tahun dari input, default ke tahun sekarang
        $tahun = $request->input('tahun', now()->year);

        // Ambil semua data target produk per sales untuk tahun tersebut
        $targets = SalesProductTarget::when($tahun, fn ($q) => $q->where('tahun', $tahun))
            ->orderBy('tahun', 'desc')
            ->get();

        // Dikirim ke view target/sales.blade.php (atau sesuai view-mu)
        return view('target.sales', compact('targets', 'tahun', 'sales'));
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
