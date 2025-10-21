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
        'regional',
        'bulan',
        'tahun',
        'datel',
        'ro',
        'sto',
        'nama',
        'segmen',
        'kcontact',
        'jenis_layanan',
        'channel',
        'cek_netmonk',
        'cek_pijar_mahir',
        'cek_eazy_cam',
        'cek_oca',
        'cek_pijar_sekolah',

        // Kode Sales
        'kode_sales',
    ];

    public function sales()
    {
        return $this->belongsTo(Sales::class, 'kode_sales', 'kode_sales');
    }

    public function prodigi()
    {
        return $this->belongsTo(Prodigi::class, 'no_internet', 'nd');
    }

    public function getCekNetmonkAttribute($value)
    {
        // jika ada relasi prodigi dan paketnya 'netmonk'
        return $this->prodigi && strtolower($this->prodigi->paket) === 'netmonk' ? 1 : 0;
    }

    public function getCekPijarMahirAttribute($value)
    {
        return $this->prodigi && strtolower($this->prodigi->paket) === 'pijar_mahir' ? 1 : 0;
    }

    public function getCekEazyCamAttribute($value)
    {
        return $this->prodigi && strtolower($this->prodigi->paket) === 'eazy' ? 1 : 0;
    }

    public function getCekOcaAttribute()
    {
        return $this->prodigi && strtolower($this->prodigi->paket) === 'oca' ? 1 : 0;
    }

    public function getCekPijarSekolahAttribute()
    {
        return $this->prodigi && strtolower($this->prodigi->paket) === 'pijar_sekolah' ? 1 : 0;
    }
}
