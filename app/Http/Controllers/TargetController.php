<?php

namespace App\Http\Controllers;

use App\Models\Target;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TargetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $bulan = $request->get('bulan');
        $tahun = $request->get('tahun');
        $perPage = 10;

        // Base query reusable
        $query = fn ($type) => Target::where('target_type', $type)
            ->when(! empty($bulan), fn ($q) => $q->where('bulan', $bulan))
            ->when(! empty($tahun), fn ($q) => $q->where('tahun', $tahun));

        // Target per type
        $targetAgency = $query('agency')->paginate($perPage)->withQueryString();
        $targetProdigi = $query('prodigi')->paginate($perPage)->withQueryString();
        $targetSales = Target::where('target_type', 'sales')
            ->when(! empty($tahun), fn ($q) => $q->where('tahun', $tahun))
            ->paginate($perPage)
            ->withQueryString();

        return view('target.index', compact('targetAgency', 'targetProdigi', 'targetSales', 'bulan', 'tahun'));
    }

    public function show(Target $target)
    {
        // Opsional
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'target_type' => 'required|in:agency,prodigi,sales',
            'target_ref' => [
                'required', 'string', 'max:255',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->target_type === 'sales') {
                        $exists = Target::where('target_type', 'sales')
                            ->where('target_ref', $value)
                            ->where('tahun', $request->tahun)
                            ->exists();
                        if ($exists) {
                            $fail('Target tahunan untuk sales ini sudah ada pada tahun tersebut.');
                        }
                    }
                },
            ],
            'bulan' => [
                // bulan hanya wajib kalau bukan sales
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->target_type !== 'sales' && empty($value)) {
                        $fail('Kolom bulan wajib diisi untuk target agency/prodigi.');
                    }
                },
                'nullable', 'integer', 'min:1', 'max:12',
            ],
            'tahun' => 'required|integer|min:2020|max:2100',
            'target_value' => 'required|numeric|min:0',
        ]);

        // Simpan data
        Target::create($request->only(['target_type', 'target_ref', 'bulan', 'tahun', 'target_value']));

        // Tentukan redirect berdasarkan tipe target
        $routeName = match ($request->target_type) {
            'agency' => 'target.index',
            'prodigi' => 'target.index',
            'sales' => 'setting.sales',
        };

        // Parameter redirect
        $params = ['tahun' => $request->tahun];
        if ($request->target_type !== 'sales') {
            $params['bulan'] = $request->bulan;
        }

        return redirect()->route($routeName, $params)
            ->with('success', 'Target berhasil ditambahkan!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Target $target)
    {
        $request->validate([
            'target_type' => 'required|in:agency,prodigi,sales',
            'target_ref' => [
                'required', 'string', 'max:255',
                function ($attribute, $value, $fail) use ($request, $target) {
                    if ($request->target_type === 'sales') {
                        $exists = Target::where('target_type', 'sales')
                            ->where('target_ref', $value)
                            ->where('tahun', $request->tahun)
                            ->where('id', '!=', $target->id)
                            ->exists();
                        if ($exists) {
                            $fail('Target tahunan untuk sales ini sudah ada pada tahun tersebut.');
                        }
                    }
                },
            ],
            'bulan' => [
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->target_type !== 'sales' && empty($value)) {
                        $fail('Kolom bulan wajib diisi untuk target agency/prodigi.');
                    }
                },
                'nullable', 'integer', 'min:1', 'max:12',
            ],
            'tahun' => 'required|integer|min:2020|max:2100',
            'target_value' => 'required|numeric|min:0',
        ]);

        $target->update($request->only(['target_type', 'target_ref', 'bulan', 'tahun', 'target_value']));

        // Tentukan redirect berdasarkan tipe target
        $routeName = match ($request->target_type) {
            'agency' => 'target.index',
            'prodigi' => 'target.index',
            'sales' => 'setting.sales',
        };

        // Parameter redirect
        $params = ['tahun' => $request->tahun];
        if ($request->target_type !== 'sales') {
            $params['bulan'] = $request->bulan;
        }

        return redirect()->route($routeName, $params)
            ->with('success', 'Target berhasil diperbarui!');
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
