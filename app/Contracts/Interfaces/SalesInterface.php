<?php

namespace App\Contracts\Interfaces;

use App\Contracts\Interfaces\Eloquent\{
    BaseInterface,
    FindByIdInterface,
    PaginateInterface
};

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface SalesInterface extends
    BaseInterface,
    FindByIdInterface,
    PaginateInterface
{
    public function getAllSales(int $perPage = 10, ?string $keyword = null): LengthAwarePaginator;
    public function getSalesTerbaru(int $limit = 3): Collection;
}
