<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prodigi extends Model
{
    use HasFactory;

    protected $table = 'prodigi';

    protected $fillable = [
        'nd',
        'order_id',
        'tanggal_ps',
        'telda',
        'customer_name',
        'paket',
        'witel',
        'rev',
        'device',
    ];
}
