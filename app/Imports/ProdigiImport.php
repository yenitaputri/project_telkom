<?php

namespace App\Imports;

use App\Models\Prodigi;
use Maatwebsite\Excel\Concerns\WithStartRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ProdigiImport implements ToCollection, WithStartRow
{
    public function startRow(): int
    {
        return 4;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Kolom A-J → index 0-8
            $orderIdKiri = $row[0] ?? null; // kolom A
            $witelKiri = $row[1] ?? null; // kolom D
            $teldaKiri = $row[2] ?? null; // kolom E
            $paketKiri = $row[3] ?? null; // kolom F
            $tglPsKiri = $row[5] ?? null; // kolom G
            $ndKiri = $row[6] ?? null; // kolom B
            $customerKiri = $row[7] ?? null; // kolom C
            $revKiri = $row[8] ?? null; // kolom H
            $deviceKiri = $row[9] ?? null; // kolom I

            // Kolom L-T → index 11-19
            $orderIdKanan = $row[11] ?? null; // kolom L
            $witelKanan = $row[12] ?? null;
            $teldaKanan = $row[13] ?? null;
            $paketKanan = $row[14] ?? null;
            $tglPsKanan = $row[15] ?? null;
            $ndKanan = $row[16] ?? null;
            $customerKanan = $row[17] ?? null;
            $revKanan = $row[18] ?? null;
            $deviceKanan = $row[19] ?? null;

            // ============ Data blok kiri ============
            // if (! empty($orderIdKiri)) {
            //     $witel = strtolower(trim($witelKiri));
            //     $telda = strtolower(trim($teldaKiri));

            //     if ($witel == 'jatim timur' && $telda == 'banyuwangi') {
            //         Prodigi::create([
            //             'order_id' => $orderIdKiri,
            //             'nd' => $ndKiri,
            //             'customer_name' => $customerKiri,
            //             'witel' => $witelKiri,
            //             'telda' => $teldaKiri,
            //             'paket' => $paketKiri,
            //             'tanggal_ps' => $this->convertDate($tglPsKiri)->format('Y-m-d'),
            //             'rev' => $revKiri,
            //             'device' => $deviceKiri,
            //         ]);
            //     }
            // }

            // ============ Data blok kanan ============
            if (! empty($orderIdKanan)) {
                $witel = strtolower(trim($witelKanan));
                $telda = strtolower(trim($teldaKanan));

                if ($witel == 'jatim timur' && $telda == 'banyuwangi') {
                    Prodigi::create([
                        'nd' => $ndKanan,
                        'order_id' => $orderIdKanan,
                        'tanggal_ps' => $this->convertDate($tglPsKanan)->format('Y-m-d'),
                        'telda' => $teldaKanan,
                        'customer_name' => $customerKanan,
                        'paket' => $paketKanan,
                        'witel' => $witelKanan,
                        'rev' => $revKanan,
                        'device' => $deviceKanan,
                    ]);
                }
            }
        }
    }

    private function convertDate($value)
    {
        if (empty($value)) {
            return now();
        }
        if (is_numeric($value)) {
            return Date::excelToDateTimeObject($value);
        }
        return \Carbon\Carbon::parse($value);
    }
}
