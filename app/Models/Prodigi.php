<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prodigi extends Model
{
    use HasFactory;

    protected $table = 'prodigi';

    protected $fillable = [
        'order_id',
        'nd',
        'customer_name',
        'witel',
        'telda',
        'paket',
        'tanggal_ps',
        'rev',
        'device',
    ];
}
