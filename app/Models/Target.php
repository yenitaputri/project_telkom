<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Target extends Model
{
    use HasFactory;

    protected $table = 'targets';

    protected $fillable = [
        'target_type',   // Jenis target: agency atau prodigi
        'bulan',         // Bulan target
        'tahun',         // Tahun target
        'target_ref',    // Nama atau kode referensi agency/prodigi
        'target_value',  // Nilai target
    ];

    /**
     * Relasi ke model Sales (jika target_type = 'agency')
     * Bisa disesuaikan ke model Agency jika nanti dibuat.
     */
    public function agency()
    {
        return $this->belongsTo(Sales::class, 'target_ref', 'agency');
    }

    /**
     * Relasi ke model Prodigi (jika target_type = 'prodigi')
     * Opsional — buat nanti kalau ada model Prodigi.
     */
    public function prodigi()
    {
        return $this->belongsTo(Prodigi::class, 'target_ref', 'nama_prodigi');
    }

    /**
     * Scope untuk filter berdasarkan tipe target 'agency'
     */
    public function scopeAgency($query)
    {
        return $query->where('target_type', 'agency');
    }

    /**
     * Scope untuk filter berdasarkan tipe target 'prodigi'
     */
    public function scopeProdigi($query)
    {
        return $query->where('target_type', 'prodigi');
    }

    /**
     * Scope untuk filter berdasarkan bulan dan tahun.
     * Opsional: hanya terapkan filter jika keduanya tidak kosong.
     */
    public function scopePeriode($query, $bulan = null, $tahun = null)
    {
        if ($bulan) {
            $query->where('bulan', $bulan);
        }

        if ($tahun) {
            $query->where('tahun', $tahun);
        }

        return $query;
    }
}
