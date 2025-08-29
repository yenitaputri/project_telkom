<?php

namespace Database\Seeders;

use App\Models\Prodigi;
use Illuminate\Database\Seeder;

class ProdigiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'order_id' => '0123456789',
                'nd' => '87654321',
                'customer_name' => 'Budi Santoso',
                'witel' => 'Jakarta Pusat',
                'telda' => '021-1234567',
                'paket' => 'Indihome 1P',
                'tanggal_ps' => '2024-08-18',
            ],
            [
                'order_id' => '0123456790',
                'nd' => '98765432',
                'customer_name' => 'Siti Aminah',
                'witel' => 'Bandung Selatan',
                'telda' => '022-9876543',
                'paket' => 'Indihome 2P',
                'tanggal_ps' => '2024-08-17',
            ],
            [
                'order_id' => '0123456791',
                'nd' => '12345678',
                'customer_name' => 'Joko Susilo',
                'witel' => 'Surabaya Barat',
                'telda' => '031-2345678',
                'paket' => 'Indihome 3P',
                'tanggal_ps' => '2024-08-16',
            ],
        ];

        foreach ($data as $item) {
            Prodigi::create($item);
        }
    }
}
