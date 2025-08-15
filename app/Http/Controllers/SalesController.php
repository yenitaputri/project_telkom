<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\SalesInterface;
use Illuminate\Http\Request;
use App\Models\Sales;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreSalesRequest;
use App\Http\Requests\UpdateSalesRequest;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $perPage = request()->get('per_page', 10); // default 10 baris
        $sales = Sales::latest()->paginate($perPage);
        return view('sales.index', compact('sales'));
    }

    public function store(StoreSalesRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('gambar_sales')) {
            $data['gambar_sales'] = $request->file('gambar_sales')->store('sales', 'public'); // Simpan di storage/app/public/sales
        }

        Sales::create($data);

        return redirect()->route('sales.index')->with('success', 'Data berhasil ditambahkan.');
    }

    public function update(UpdateSalesRequest $request, $id)
{
    $sales = Sales::findOrFail($id);

    // Ambil semua data yang sudah tervalidasi
    $validated = $request->validated();

    // Proses gambar
    if ($request->hasFile('gambar_sales')) {
        // Hapus gambar lama jika ada
        if ($sales->gambar_sales && Storage::exists('public/' . $sales->gambar_sales)) {
            Storage::delete('public/' . $sales->gambar_sales);
        }

        // Simpan gambar baru
        $validated['gambar_sales'] = $request->file('gambar_sales')->store('sales', 'public');
    } else {
        // Jika tidak ada gambar baru, tetap gunakan gambar lama
        $validated['gambar_sales'] = $sales->gambar_sales;
    }

    // Update semua kolom
    $sales->update($validated);

    return redirect()->route('sales.index')->with('success', 'Data sales berhasil diperbarui.');
}


    public function destroy(Sales $sale)
    {
        // Hapus file gambar dari storage jika ada
        if ($sale->gambar_sales) {
            Storage::delete($sale->gambar_sales);
        }

        // Hapus data sales dari database
        $sale->delete();

        // Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('sales.index')->with('success', 'Data sales berhasil dihapus!');
    }
}
