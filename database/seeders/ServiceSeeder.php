<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    public function run()
    {
        $services = [
            ['name' => 'Morning Service'],
            ['name' => 'Evening Service'],
            ['name' => 'Youth Service'],
            ['name' => 'Children Service'],
        ];

        foreach ($services as $service) {
            Service::firstOrCreate(['name' => $service['name']], $service);
        }
    }
}
