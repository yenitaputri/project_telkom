<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function index()
    {
        // Di sini Anda bisa mengambil data pelanggan dari database
        // $customers = Customer::all();
        // return view('customers.index', compact('customers'));
        return view('pelanggan.index');
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
        $data = [
            'no_internet' => '152516209310',
            'no_digital' => '152516209310',
            'tanggal_ps' => '08/07/2023',
            'kecepatan' => '200',
            'bulan' => '7',
            'tahun' => '2025',
            'datel' => 'BNYWANGI',
            'ro' => '',
            'sto' => 'RGJ',
            'nama' => 'Toko Rofi / MOH ROFIUDIN',
            'segmen' => 'DBS-Commerce & Community Serv',
            'kcontact' => 'DS/05/JR/DS50205/MUHLAS/DIGIBIZ 75MBPS/PIC 81217766672',
            'jenis_layanan' => 'INDIBIZ',
            'channel_1' => 'Sales Force DBS',
            'cek_netmonk' => '',
            'cek_pijar_mahir' => '',
            'cek_eazy_cam' => '',
            'cek_oca' => '',
            'cek_pijar_sekolah' => '',
            'kode_sales' => 'DS50216',
            'nama_sf' => 'RYZAL RYAN (BLM)',
            'agency' => 'MCA',
        ];
        return view('pelanggan.show', compact('data'));
    }
}
