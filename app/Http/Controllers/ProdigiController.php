<?php

namespace App\Http\Controllers;

use App\Http\Requests\Prodigi\ImportProdigiRequest;
use App\Http\Requests\Prodigi\UpdateProdigiRequest;
use App\Imports\ProdigiImport;
use App\Models\Prodigi;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class ProdigiController extends Controller
{
    public function index(Request $request)
    {
        $query = Prodigi::query();

        // filter pencarian
        if ($request->has('q') && $request->q != '') {
            $query->where('customer_name', 'like', "%{$request->q}%")
                ->orWhere('order_id', 'like', "%{$request->q}%")
                ->orWhere('nd', 'like', "%{$request->q}%");
        }

        // filter tanggal
        if ($request->filled('start') && $request->filled('end')) {
            $startDate = Carbon::parse($request->start)->format('Y-m-d');
            $endDate = Carbon::parse($request->end)->format('Y-m-d');

            $query->whereBetween('tanggal_ps', [$startDate, $endDate]);
        }

        $perPage = $request->get('per_page', 10);
        $prodigi = $query->orderByDesc('created_at')
            ->paginate($perPage)
            ->appends($request->query());

        return view('prodigi.index', compact('prodigi'));
    }

    public function store(ImportProdigiRequest $request)
    {
        Excel::import(new ProdigiImport, $request->file('file_upload'));

        // Redirect dengan pesan sukses
        return redirect()->route('prodigi.index')->with('success', 'Data pelanggan berhasil ditambahkan');
    }

    public function show($id)
    {

        // Cari data berdasarkan ID, jika tidak ada, tampilkan halaman 404
        $prodigi = Prodigi::findOrFail($id);

        // Kirim data ke view
        return view('prodigi.show', compact('prodigi'));
    }

    public function edit($id, Request $request)
    {
        $page = $request->input('page', 1);

        // Data statis untuk halaman edit
        $data = Prodigi::findOrFail($id);
        return view('prodigi.edit', ['prodigi' => $data, 'page' => $page]);
    }

    public function update(UpdateProdigiRequest $request, $id)
    {
        $prodigi = Prodigi::findOrFail($id);
        $prodigi->update($request->validated());

        return redirect()
            ->route('prodigi.index', ['page' => $request->input('page')])
            ->with('success', 'Data prodigi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        // Cari data berdasarkan ID
        $prodigi = Prodigi::findOrFail($id);

        // Hapus data
        $prodigi->delete();

        // Redirect kembali dengan pesan sukses
        return redirect()->route('prodigi.index')
            ->with('success', 'Data Prodigi berhasil dihapus');
    }
}