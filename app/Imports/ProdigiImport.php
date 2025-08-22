<?php

namespace App\Imports;

use App\Models\Prodigi;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProdigiImport implements ToCollection, WithHeadingRow
{
    public function headingRow(): int
    {
        return 3; // row ke-3 dianggap header
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // ========================
            // Data blok kiri (kolom A-J)
            // ========================
            if (!empty($row['order_id'])) {
                $tanggal = $this->convertDate($row['tgl_ps']);
                Prodigi::create([
                    'order_id' => $row['order_id'] ?? null,
                    'nd' => $row['nd'] ?? null,
                    'customer_name' => $row['customer_name'] ?? null,
                    'witel' => $row['witel'] ?? null,
                    'telda' => $row['telda'] ?? null,
                    'produk' => $row['paket'] ?? null,
                    'tanggal_ps' => $tanggal->format('Y-m-d') ?? null,
                    'rev' => $row['rev'] ?? null,
                    'device' => $row['device'] ?? null,
                ]);
            }

            // ========================
            // Data blok kanan (kolom L-T → auto jadi *_2)
            // ========================
            if (!empty($row['order_id_2'])) {
                $tanggal = $this->convertDate($row['tgl_ps_2']);
                Prodigi::create([
                    'order_id' => $row['order_id_2'] ?? null,
                    'nd' => $row['nd_2'] ?? null,
                    'customer_name' => $row['customer_name_2'] ?? null,
                    'witel' => $row['witel_2'] ?? null,
                    'telda' => $row['telda_2'] ?? null,
                    'produk' => $row['paket_2'] ?? null,
                    'tanggal_ps' => $tanggal->format('Y-m-d') ?? null,
                    'rev' => $row['rev_2'] ?? null,
                    'device' => $row['device_2'] ?? null,
                ]);
            }
        }
    }

    private function convertDate($value)
    {
        if (is_numeric($value)) {
            return Date::excelToDateTimeObject($value);
        }
        return \Carbon\Carbon::parse($value);
    }
}
