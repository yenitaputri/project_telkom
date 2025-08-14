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
        $tanggal = $this->convertDate($row['order_date']);
        $kecepatan = $this->extractMbps($row['package_name']);

        return new Pelanggan([
            'no_internet' => $row['order_id'],
            'no_digital' => null,
            'tanggal_ps' => $tanggal->format('Y-m-d'),
            'kecepatan' => $kecepatan,
            'bulan' => intval($tanggal->format('m')), // Ambil bulan dari tanggal_ps
            'tahun' => intval($tanggal->format('Y')), // Ambil bulan dari tanggal_ps
            'datel' => $row['datel'],
            'ro' => null,
            'sto' => $row['sto'],
            'nama' => $row['customer_name'],
            'segmen' => $row['provider'],
            'kcontact' => $row['device_id'],
            'jenis_layanan' => $row['group_paket'],
            'channel_1' => $row['channel'],
            'cek_netmonk' => null,
            'cek_pijar_mahir' => null,
            'cek_eazy_cam' => null,
            'cek_oca' => null,
            'cek_pijat_sekolah' => null,
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
        return \Carbon\Carbon::parse($value);
    }

    private function extractMbps($packageName): ?int
    {
        // Regex untuk menangkap angka sebelum "Mbps"
        if (preg_match('/(\d+)\s*Mbps/i', $packageName, $matches)) {
            return (int) $matches[1];
        }

        // Opsional: bisa juga deteksi HSIExxM
        if (preg_match('/HSIE(\d+)M/i', $packageName, $matches)) {
            return (int) $matches[1];
        }

        return null; // jika tidak ada kecepatan ditemukan
    }
}
