<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesProductTarget extends Model
{
    use HasFactory;

    protected $table = 'sales_product_targets';

    protected $fillable = [
        'product',
        'tahun',
        'target',
        'ach',
        'sk',
    ];
}
