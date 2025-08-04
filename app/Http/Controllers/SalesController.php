<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\SalesInterface;
use Illuminate\Http\Request;
use App\Models\Sales;
use App\Http\Requests\StoreSalesRequest;

class SalesController extends Controller
{
    protected SalesInterface $sales;

    public function __construct(SalesInterface $sales)
    {
        $this->sales = $sales;
    }

    public function index()
{
    $sales = Sales::latest()->get(); // <-- ini urutkan berdasarkan created_at DESC
    return view('sales.index', compact('sales'));
}


public function store(StoreSalesRequest $request)
{
    $data = $request->validated();

    if ($request->hasFile('gambar_sales')) {
        $data['gambar_sales'] = $request->file('gambar_sales')->store('sales', 'public');
    }

    Sales::create($data);

    return redirect()->route('sales.index')->with('success', 'Data berhasil ditambahkan.');
}


    // Tambahkan metode edit, update, destroy jika diperlukan
}
