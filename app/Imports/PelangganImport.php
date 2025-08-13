<?php

namespace App\Imports;

use App\Models\Pelanggan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class PelangganImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Pelanggan([
            'no_internet' => null,
            'no_digital' => null,
            'tanggal_ps' => now(), // atau mapping kolom tanggal kalau ada
            'kecepatan' => $row['addon'] ?? null,
            'bulan' => date('m'),
            'tahun' => date('Y'),
            'datel' => $row['datel'] ?? null,
            'ro' => null, // isi kalau ada di file
            'sto' => $row['sto'] ?? null,
            'nama' => null, // isi sesuai kolom excel
            'segmen' => null,
            'kcontact' => null,
            'jenis_layanan' => $row['jenis_psb'] ?? null,
            'channel_1' => $row['type_transaksi'] ?? null,
            'kode_sales' => null,
            'nama_sf' => null,
            'agency' => null,
        ]);
    }

    private function convertDate($value)
    {
        if (is_numeric($value)) {
            return Date::excelToDateTimeObject($value);
        }
        return $value;
    }
}
