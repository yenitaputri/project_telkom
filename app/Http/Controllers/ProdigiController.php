<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImportProdigiRequest;
use App\Imports\ProdigiImport;
use App\Models\Prodigi;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

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
            $query->whereBetween('tanggal_ps', [$request->start, $request->end]);
        }

        $perPage = $request->get('per_page', 10);
        $prodigi = $query->paginate($perPage)->appends($request->query());

        return view('prodigi.index', compact('prodigi'));
    }

    public function store(ImportProdigiRequest $request)
    {
        // // Ambil data yang sudah divalidasi dari Form Request
        // $validated = $request->validated();

        // // Simpan data ke database
        // Pelanggan::create($validated);

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
        return view('pelanggan.edit', ['pelanggan' => $data, 'page' => $page]);
    }

    public function update(UpdatePelangganRequest $request, $id)
    {
        $pelanggan = Prodigi::findOrFail($id);
        $pelanggan->update($request->validated());

        return redirect()
            ->route('prodigi.index', ['page' => $request->input('page')])
            ->with('success', 'Data prodigi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        // Cari data berdasarkan ID
        $pelanggan = Prodigi::findOrFail($id);

        // Hapus data
        $pelanggan->delete();

        // Redirect kembali dengan pesan sukses
        return redirect()->route('prodigi.index')
            ->with('success', 'Data Prodigi berhasil dihapus');
    }
}