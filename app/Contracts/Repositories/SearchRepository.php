<?php

namespace App\Repositories;

use App\Contracts\Interfaces\SearchInterface;
use App\Models\Sales;
use App\Models\Product;
use App\Models\Customer;

class SearchRepository implements SearchInterface
{
    public function search(string $keyword): array
    {
        $results = [];

        // Contoh pencarian di tabel sales
        $sales = Sales::where('name', 'like', "%{$keyword}%")
            ->orWhere('email', 'like', "%{$keyword}%")
            ->get();
        if ($sales->isNotEmpty()) {
            $results['sales'] = $sales;
        }

        // Contoh pencarian di tabel produk
        $products = Product::where('name', 'like', "%{$keyword}%")
            ->orWhere('description', 'like', "%{$keyword}%")
            ->get();
        if ($products->isNotEmpty()) {
            $results['products'] = $products;
        }

        // Contoh pencarian di tabel customer
        $customers = Customer::where('name', 'like', "%{$keyword}%")
            ->orWhere('email', 'like', "%{$keyword}%")
            ->get();
        if ($customers->isNotEmpty()) {
            $results['customers'] = $customers;
        }

        return $results;
    }
}
