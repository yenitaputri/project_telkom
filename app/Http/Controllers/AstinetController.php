<?php

namespace App\Http\Controllers;
use App\Models\Astinet;
use App\Models\Sales;
use Illuminate\Http\Request;

class AstinetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Astinet::query();

        if ($request->has('q')) {
            $query->where('kode_order', 'like', "%{$request->q}%")
                ->orWhere('nama_pelanggan', 'like', "%{$request->q}%")
                ->orWhere('nama_sales', 'like', "%{$request->q}%");
        }

        $perPage = $request->get('per_page', 10);

        $astinets = $query->orderBy('id', 'desc')->paginate($perPage);

        return view('astinet.index', compact('astinets'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sales = Sales::all();
        return view('astinet.create', compact('sales')); // pastikan folder dan nama file sesuai: resources/views/astinet/create.blade.php
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_order' => 'required|unique:astinet',
            'sid' => 'nullable|string',
            'bandwidth' => 'required|numeric',
            'nama_pelanggan' => 'required|string',
            'nama_sales' => 'required|string',
            'tanggal_complete' => 'nullable|date',
        ]);

        Astinet::create($request->all());

        return redirect()->route('astinet.index')->with('success', 'Data berhasil ditambahkan!');
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
    public function edit(Astinet $astinet)
    {
        $sales = Sales::all();
        return view('astinet.edit', compact('astinet', 'sales'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Astinet $astinet)
    {
        $request->validate([
            'kode_order' => 'required|unique:astinet,kode_order,'.$astinet->id,
            'sid' => 'nullable|string',
            'bandwidth' => 'required|numeric',
            'nama_pelanggan' => 'required|string',
            'nama_sales' => 'required|string',
            'tanggal_complete' => 'nullable|date',
        ]);

        $astinet->update($request->all());

        return redirect()->route('astinet.index')->with('success', 'Data berhasil diperbarui!');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Astinet $astinet)
    {
        $astinet->delete();
        return redirect()->route('astinet.index')->with('success', 'Data berhasil dihapus!');
    }
}
