<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;
use function PHPUnit\Framework\returnArgument;

class PelangganController extends Controller
{
    public function index()
    {
        $pelanggan = Pelanggan::all();

        return view('pelanggan.index', compact('pelanggan'));
    }

    public function create()
    {
        return view('pelanggan.create');
    }

    public function store(Request $request)
    {
        // Validasi data
        $validated = $request->validate([
            'no_internet' => 'required|string|max:50',
            'no_digital' => 'required|string|max:50',
            'tanggal_ps' => 'required|date',
            'datel' => 'required|string|max:50',
            'sto' => 'required|string|max:50',
            'nama' => 'required|string|max:100',
        ]);

        // Simpan data ke database
        // Customer::create($validated);

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
}
