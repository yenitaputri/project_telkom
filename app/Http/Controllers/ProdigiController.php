<?php

namespace App\Http\Controllers;

use App\Models\Prodigi;
use Illuminate\Http\Request;

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

    public function show($id)
    {

        // Cari data berdasarkan ID, jika tidak ada, tampilkan halaman 404
        $prodigi = Prodigi::findOrFail($id);

        // Kirim data ke view
        return view('prodigi.show', compact('prodigi'));
    }
}