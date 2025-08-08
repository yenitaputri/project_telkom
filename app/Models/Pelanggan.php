<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    /** @use HasFactory<\Database\Factories\PelangganFactory> */
    use HasFactory;

    protected $table = 'pelanggan';

    protected $fillable = [
        'no_internet',
        'no_digital',
        'tanggal_ps',
        'kecepatan',
        'bulan',
        'tahun',
        'datel',
        'ro',
        'sto',
        'nama',
        'segmen',
        'kcontact',
        'jenis_layanan',
        'channel_1',
        'kode_sales',
        'nama_sf',
        'agency',
    ];
}
