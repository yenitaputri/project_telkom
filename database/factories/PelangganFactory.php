<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pelanggan>
 */
class PelangganFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'no_internet' => $this->faker->unique()->numerify('152516######'),
            'no_digital' => $this->faker->numerify('152516######'),
            'tanggal_ps' => $this->faker->date('Y-m-d'),
            'kecepatan' => $this->faker->randomElement(['50', '100', '200', '300']),
            'bulan' => $this->faker->numberBetween(1, 12),
            'tahun' => $this->faker->numberBetween(2023, 2025),
            'datel' => $this->faker->randomElement(['BNYWANGI', 'JEMBER', 'SITUBONDO', 'BONDOWOSO']),
            'ro' => '',
            'sto' => $this->faker->randomElement(['RGJ', 'JBR', 'STB', 'BDW']),
            'nama' => $this->faker->company . ' / ' . $this->faker->name,
            'segmen' => $this->faker->randomElement([
                'DBS-Commerce & Community Serv',
                'DBS-Corporate',
                'DBS-SME'
            ]),
            'kcontact' => strtoupper($this->faker->bothify('DS/##/JR/DS#####/###/DIGIBIZ ?0MBPS/PIC 8##########')),
            'jenis_layanan' => 'INDIBIZ',
            'channel_1' => $this->faker->randomElement(['Sales Force DBS', 'Corporate Sales', 'Sales Force SME']),
            'kode_sales' => 'DS' . $this->faker->numerify('#####'),
            'nama_sf' => $this->faker->name . ' (BLM)',
            'agency' => $this->faker->randomElement(['MCA', 'TELEPARTNER', 'MITRA TELEKOM']),
        ];
    }
}
