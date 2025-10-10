<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    use HasFactory;

    protected $table = 'sales'; // Pastikan nama tabelnya benar

    protected $fillable = [
        'gambar_sales',
        'kode_sales',
        'nama_sales',
        'agency',
    ];
    public function pelanggans()
    {
        return $this->hasMany(Pelanggan::class, 'kode_sales', 'kode_sales');
    }
}
