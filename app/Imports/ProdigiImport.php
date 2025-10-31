<?php

namespace App\Imports;

use App\Models\Prodigi;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Carbon\Carbon;

class ProdigiImport implements ToCollection, WithStartRow
{
    public function startRow(): int
    {
        return 4;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Kolom A-J → index 0-9
            $orderIdKiri = $row[0] ?? null;
            $witelKiri = $row[1] ?? null;
            $teldaKiri = $row[2] ?? null;
            $paketKiri = $row[3] ?? null;
            $tglPsKiri = $row[5] ?? null;
            $ndKiri = $row[6] ?? null;
            $customerKiri = $row[7] ?? null;
            $revKiri = $row[8] ?? null;
            $deviceKiri = $row[9] ?? null;

            // Kolom L-T → index 11-19
            $orderIdKanan = $row[11] ?? null;
            $witelKanan = $row[12] ?? null;
            $teldaKanan = $row[13] ?? null;
            $paketKanan = $row[14] ?? null;
            $tglPsKanan = $row[15] ?? null;
            $ndKanan = $row[16] ?? null;
            $customerKanan = $row[17] ?? null;
            $revKanan = $row[18] ?? null;
            $deviceKanan = $row[19] ?? null;

            // ============ Data blok kanan ============
            if (! empty($orderIdKanan)) {
                $witel = strtolower(trim($witelKanan));
                $telda = strtolower(trim($teldaKanan));

                // Log sebelum konversi
                if (config('app.debug')) {
                    Log::info('Customer: '.$customerKanan);
                    Log::info('Tanggal sebelum konversi', [
                        'raw' => $tglPsKanan,
                        'type' => gettype($tglPsKanan),
                    ]);
                }

                // Konversi tanggal
                $converted = $this->convertDate($tglPsKanan);

                // Log sesudah konversi
                if (config('app.debug')) {
                    Log::info('Tanggal sesudah konversi', [
                        'converted' => $converted,
                    ]);
                }

                if ($witel === 'jatim timur' && $telda === 'banyuwangi') {
                    Prodigi::create([
                        'nd' => $ndKanan,
                        'order_id' => $orderIdKanan,
                        'tanggal_ps' => $converted,
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
            return null;
        }

        // Jika numeric (serial Excel)
        if (is_numeric($value)) {
            $dateObj = Date::excelToDateTimeObject($value);
            return Carbon::instance($dateObj)->format('Y-d-m');
        }

        // Jika string (misalnya "9/8/2025")
        $value = trim($value);

        // Coba format n/j/Y (misal 9/8/2025)
        try {
            return Carbon::createFromFormat('n/j/Y', $value)->format('Y-m-d');
        } catch (\Exception $e) {
        }

        // Coba format d/m/Y (misal 09/08/2025)
        try {
            return Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
        } catch (\Exception $e) {
        }

        // Fallback ke parser bawaan Carbon
        return Carbon::parse($value)->format('Y-m-d');
    }
}
