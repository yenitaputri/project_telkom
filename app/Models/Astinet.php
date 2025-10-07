<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Astinet extends Model
{
    use HasFactory;

    protected $table = 'astinet'; // <-- pakai nama tabel custom

    protected $fillable = [
        'kode_order',
        'sid',
        'bandwidth',
        'nama_pelanggan',
        'nama_sales',
        'tanggal_complete',
    ];
}
