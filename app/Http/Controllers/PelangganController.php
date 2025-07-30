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
}