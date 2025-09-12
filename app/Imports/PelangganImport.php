<?php

namespace App\Imports;

use App\Models\Pelanggan;
use App\Models\Sales;
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
        $kodeSales = $this->extractKodeSales($row['device_id']);

        $namaSF = null;
        $agency = null;

        if (isset($kodeSales)) {
            // satu query, ambil field yang diperlukan
            $sales = Sales::select('nama_sales', 'agency')
                ->where('kode_sales', $kodeSales)
                ->first();

            if ($sales) {
                $namaSF = $sales->nama_sales;
                $agency = $sales->agency;
            }
        }

        return new Pelanggan([
            'no_internet' => trim($row['ndem'], "'"),
            'no_digital' => null,
            'tanggal_ps' => $tanggal->format('Y-m-d'),
            'kecepatan' => $kecepatan,
            'regional' => $row['regional'] == 3 ? 5 : null, // Jika 3 maka menjadi 5, jika tidak maka null
            'bulan' => intval($tanggal->format('m')), // Ambil bulan dari tanggal_ps
            'tahun' => intval($tanggal->format('Y')), // Ambil bulan dari tanggal_ps
            'datel' => $row['datel'],
            'ro' => null,
            'sto' => $row['sto'],
            'nama' => $row['customer_name'],
            'segmen' => $row['provider'] == 'RBS-Regional 3' ? 'REG-Regional 5' : $row['provider'],
            'kcontact' => $row['device_id'],
            'channel' => $row['channel'],
            // 'jenis_layanan' => $row['channel'] == 'MYDIGIBIZPARTNER' ? 'OTHER' : 'INDIBIZ',
            'jenis_layanan' => 'INDIBIZ',
            'cek_netmonk' => null,
            'cek_pijar_mahir' => null,
            'cek_eazy_cam' => null,
            'cek_oca' => null,
            'cek_pijat_sekolah' => null,

            // Kode Sales
            'kode_sales' => $kodeSales,
            'nama_sf' => $namaSF,
            'agency' => $agency,
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

    private function extractKodeSales($text)
    {
        if (preg_match('/\bM\d{7,}\b/', $text, $matches)) {
            return $matches[0]; // Ambil kode_sales
        }
        return null; // Jika tidak ketemu
    }
}
