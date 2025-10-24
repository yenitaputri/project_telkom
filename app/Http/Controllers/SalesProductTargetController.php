<?php

namespace App\Http\Controllers;

use App\Models\SalesProductTarget;
use Illuminate\Http\Request;

class SalesProductTargetController extends Controller
{
    public function index(Request $request)
    {
        $tahun = $request->get('tahun');

        $query = SalesProductTarget::query()
            ->when($tahun, fn ($q) => $q->where('tahun', $tahun))
            ->orderBy('product', 'asc');

        $targets = $query->paginate(10);
        $totalAch = $query->sum('ach');
        $totalSk = $query->sum('sk');

        // arahkan ke view target.sales (bukan sales_product_target.index)
        return view('target.sales', compact('targets', 'totalAch', 'totalSk', 'tahun'));
    }

    public function create()
    {
        return view('sales_product_target.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product' => 'required|string|max:255',
            'tahun' => 'required|integer',
            'ach' => 'nullable|integer|min:0',
            'sk' => 'nullable|integer|min:0',
        ]);

        SalesProductTarget::create($validated);

        return redirect()
            ->route('setting.sales')
            ->with('success', 'Sales product target created successfully.');
    }

    public function show($id)
    {
        $target = SalesProductTarget::findOrFail($id);
        return view('sales_product_target.show', compact('target'));
    }

    public function edit($id)
    {
        $target = SalesProductTarget::findOrFail($id);
        return view('sales_product_target.edit', compact('target'));
    }

    public function update(Request $request, $id)
    {
        $target = SalesProductTarget::findOrFail($id);

        $validated = $request->validate([
            'product' => 'required|string|max:255',
            'tahun' => 'required|integer',
            'ach' => 'nullable|integer|min:0',
            'sk' => 'nullable|integer|min:0',
        ]);

        $target->update($validated);

        return redirect()
            ->route('setting.sales')
            ->with('success', 'Sales product target updated successfully.');
    }

    public function destroy($id)
    {
        $target = SalesProductTarget::findOrFail($id);
        $target->delete();

        return redirect()
            ->route('setting.sales')
            ->with('success', 'Sales product target deleted successfully.');
    }
}
