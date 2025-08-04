<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\SalesInterface;
use Illuminate\Http\Request;
use App\Models\Sales;
use App\Http\Requests\StoreSalesRequest;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('sales.index'); // Akan menggunakan layout 'app' melalui @extends
    }
}