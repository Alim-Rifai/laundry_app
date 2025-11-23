<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    public function run()
    {
        $services = [
            ['name' => 'Cuci Kering', 'price_per_kg' => 5000],
            ['name' => 'Cuci Setrika', 'price_per_kg' => 7000],
            ['name' => 'Setrika Saja', 'price_per_kg' => 4000],
            ['name' => 'Cuci Sepatu', 'price_per_kg' => 15000],
        ];

        foreach ($services as $s) {
            Service::create($s);
        }
    }
}
