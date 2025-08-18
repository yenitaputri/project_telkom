<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\SearchInterface;
use App\Models\Pelanggan;
use App\Models\Sales;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Support\Facades\Schema;

class SearchRepository implements SearchInterface
{
    public function search(string $keyword): array
    {
        $results = [];

        // Daftar model yang mau dicari
        $models = [
            'Sales' => Sales::class,
            'pelanggan' => Pelanggan::class,
        ];

        foreach ($models as $key => $modelClass) {
            $model = new $modelClass;
            // Gunakan properti $searchable jika ada, jika tidak, baru cari semua kolom
            $columns = property_exists($model, 'searchable')
                ? $model->searchable
                : Schema::getColumnListing($model->getTable());

            // Query pencarian di semua kolom
            $query = $modelClass::query()->where(function ($q) use ($columns, $keyword) {
                foreach ($columns as $column) {
                    $q->orWhere($column, 'like', "%{$keyword}%");
                }
            });

            $data = $query->get();

            if ($data->isNotEmpty()) {
                // Konversi semua row menjadi array
                $results[$key] = $data->map(function ($item) use ($columns) {
                    return collect($item->only($columns))->toArray();
                })->toArray(); // <- tambahkan ini supaya jadi array biasa
            }
        }

        return $results;
    }
}
