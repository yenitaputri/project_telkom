<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function index()
    {
        // Di sini Anda bisa mengambil data prodi dari database
        // $prodi = Prodi::all();
        // return view('prodi.index', compact('prodi'));
        return view('sales.index');
    }
}