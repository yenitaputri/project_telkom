<?php

namespace App\Http\Controllers;

use App\Models\Target;
use Illuminate\Http\Request;

class TargetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $bulan = $request->get('bulan'); // bisa null atau ''
        $tahun = $request->get('tahun'); // bisa null
        $perPage = 10; // jumlah data per halaman, bisa disesuaikan

        // Target Agency
        $targetAgency = Target::where('target_type', 'agency');
        if (! empty($bulan)) {
            $targetAgency->where('bulan', $bulan);
        }
        if (! empty($tahun)) {
            $targetAgency->where('tahun', $tahun);
        }
        $targetAgency = $targetAgency->paginate($perPage)->withQueryString();

        // Target Prodigi
        $targetProdigi = Target::where('target_type', 'prodigi');
        if (! empty($bulan)) {
            $targetProdigi->where('bulan', $bulan);
        }
        if (! empty($tahun)) {
            $targetProdigi->where('tahun', $tahun);
        }
        $targetProdigi = $targetProdigi->paginate($perPage)->withQueryString();

        return view('target.index', compact('targetAgency', 'targetProdigi', 'bulan', 'tahun'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Optional: bisa pakai modal di index, jadi tidak perlu halaman create terpisah
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'target_type' => 'required|in:agency,prodigi',
            'target_ref' => 'required|string|max:255',
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2020|max:2100',
            'target_value' => 'required|numeric|min:0',
        ]);

        // Simpan ke database
        Target::create($request->only([
            'target_type', 'target_ref', 'bulan', 'tahun', 'target_value'
        ]));

        // Redirect kembali ke halaman index dengan query string bulan & tahun agar filter tetap
        return redirect()->route('target.index', [
            'bulan' => $request->bulan,
            'tahun' => $request->tahun,
        ])->with('success', 'Target berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Target $target)
    {
        // Opsional
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Target $target)
    {
        // Opsional: jika ingin edit
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Target $target)
    {
        $request->validate([
            'target_type' => 'required|in:agency,prodigi',
            'target_ref' => 'required|string|max:255',
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2020|max:2100',
            'target_value' => 'required|numeric|min:0',
        ]);

        $target->update($request->only([
            'target_type', 'target_ref', 'bulan', 'tahun', 'target_value'
        ]));

        return redirect()->route('target.index', [
            'bulan' => $request->bulan,
            'tahun' => $request->tahun,
        ])->with('success', 'Target berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Target $target)
    {
        $target->delete();

        return redirect()->back()->with('success', 'Target berhasil dihapus!');
    }
}
