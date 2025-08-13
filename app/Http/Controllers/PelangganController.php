<?php

namespace App\Http\Controllers;

use App\Http\Requests\Pelanggan\ImportPelangganRequest;
use App\Http\Requests\Pelanggan\UpdatePelangganRequest;
use App\Imports\PelangganImport;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use function PHPUnit\Framework\returnArgument;

class PelangganController extends Controller
{
    public function index()
    {
        $pelanggan = Pelanggan::orderBy('id', 'asc')->paginate(10); // 10 data per halaman
        return view('pelanggan.index', compact('pelanggan'));
    }

    public function create()
    {
        return view('pelanggan.create');
    }

    public function store(ImportPelangganRequest $request)
    {
        // // Ambil data yang sudah divalidasi dari Form Request
        // $validated = $request->validated();

        // // Simpan data ke database
        // Pelanggan::create($validated);

        Excel::import(new PelangganImport, $request->file('file_upload'));

        // Redirect dengan pesan sukses
        return redirect()->route('pelanggan.index')->with('success', 'Data pelanggan berhasil ditambahkan');
    }

    public function show($id)
    {
        // Data statis untuk preview detail pelanggan
        $data = Pelanggan::findOrFail($id);

        return view('pelanggan.show', ['pelanggan' => $data]);
    }

    public function edit($id)
    {
        // Data statis untuk halaman edit
        $data = Pelanggan::findOrFail($id);
        return view('pelanggan.edit', ['pelanggan' => $data]);
    }

    public function update(UpdatePelangganRequest $request, $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->update($request->validated());

        return redirect()
            ->route('pelanggan.index')
            ->with('success', 'Data pelanggan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        // Cari data berdasarkan ID
        $pelanggan = Pelanggan::findOrFail($id);

        // Hapus data
        $pelanggan->delete();

        // Redirect kembali dengan pesan sukses
        return redirect()->route('pelanggan.index')
            ->with('success', 'Data pelanggan berhasil dihapus');
    }
}
