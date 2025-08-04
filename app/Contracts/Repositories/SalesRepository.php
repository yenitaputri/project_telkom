<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\SalesInterface;
use App\Models\Sales;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class SalesRepository extends BaseRepository implements SalesInterface
{
    public function __construct(Sales $sales)
    {
        $this->model = $sales;
    }

    public function getAllSales(int $perPage = 10, ?string $keyword = null): LengthAwarePaginator
    {
        $query = $this->model->query();

        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('nama_sales', 'like', "%{$keyword}%")
                  ->orWhere('kode_sales', 'like', "%{$keyword}%")
                  ->orWhere('agency', 'like', "%{$keyword}%");
            });
        }

        return $query->orderBy('nama_sales')->paginate($perPage);
    }

    public function getSalesTerbaru(int $limit = 3): Collection
    {
        return $this->model->latest()->take($limit)->get();
    }

    public function findById(mixed $id): Sales
    {
        return $this->model->findOrFail($id);
    }

    public function store(array $data): Sales
    {
        return $this->model->create($data);
    }

    public function update(mixed $id, array $data): bool
    {
        $sales = $this->model->findOrFail($id);
        return $sales->update($data);
    }

    public function delete(mixed $id): bool
    {
        $sales = $this->model->findOrFail($id);
        return $sales->delete();
    }

    public function paginate(int $pagination = 10): LengthAwarePaginator
    {
        return $this->model->paginate($pagination);
    }
}
