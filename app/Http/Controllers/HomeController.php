<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Sales;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $sales = Sales::all();
        $pelanggan = Pelanggan::all();

        $agency = [
            [
                'agency' => 'BLM',
                'target' => 20,
                'realisasi' => 50,
                'ach' => '250%',
                'rank' => 1,
            ],
            [
                'agency' => 'KOPEG BWI',
                'target' => 30,
                'realisasi' => 25,
                'ach' => '83.3%',
                'rank' => 3,
            ],
            [
                'agency' => 'IMD',
                'target' => 50,
                'realisasi' => 40,
                'ach' => '80%',
                'rank' => 4,
            ],
            [
                'agency' => 'JKT-01',
                'target' => 40,
                'realisasi' => 45,
                'ach' => '112%',
                'rank' => 2,
            ],
            [
                'agency' => 'SBY-AGENCY',
                'target' => 25,
                'realisasi' => 10,
                'ach' => '40%',
                'rank' => 5,
            ],
        ];

        $sales = collect([
            (object) [
                'gambar_sales' => 'sales1.jpg',
                'kode_sales' => 'S001',
                'nama_sales' => 'Budi Santoso',
            ],
            (object) [
                'gambar_sales' => 'sales2.jpg',
                'kode_sales' => 'S002',
                'nama_sales' => 'Andi Saputra',
            ],
        ]);



        return view('home.index', compact('sales', 'pelanggan', 'agency', 'sales')); // Akan dibuat di langkah view
    }
}