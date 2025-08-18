<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProdigiController extends Controller
{
    public function index()
    {
        // Di sini Anda bisa mengambil data prodi dari database
        // $prodi = Prodi::all();
        // return view('prodi.index', compact('prodi'));
        return view('prodigi.index');
    }

    public function show($id)
    {
        // Data statis untuk demonstrasi, seolah-olah diambil dari database
        $allProdigi = [
            '1' => [
                'id' => 1,
                'order_id' => '0123456789',
                'nd' => '87654321',
                'customer_name' => 'Budi Santoso',
                'witel' => 'Jakarta Pusat',
                'telda' => '021-1234567',
                'produk' => 'Indihome 1P',
                'tanggal_ps' => '2024-08-18',
            ],
            '2' => [
                'id' => 2,
                'order_id' => '0123456790',
                'nd' => '98765432',
                'customer_name' => 'Siti Aminah',
                'witel' => 'Bandung Selatan',
                'telda' => '022-9876543',
                'produk' => 'Indihome 2P',
                'tanggal_ps' => '2024-08-17',
            ],
            '3' => [
                'id' => 3,
                'order_id' => '0123456791',
                'nd' => '12345678',
                'customer_name' => 'Joko Susilo',
                'witel' => 'Surabaya Barat',
                'telda' => '031-2345678',
                'produk' => 'Indihome 3P',
                'tanggal_ps' => '2024-08-16',
            ],
        ];

        // Cari data berdasarkan ID, jika tidak ada, tampilkan halaman 404
        $prodigi = $allProdigi[$id] ?? null;
        abort_if(!$prodigi, 404);

        // Kirim data ke view
        return view('prodigi.show', compact('prodigi'));
    }
}