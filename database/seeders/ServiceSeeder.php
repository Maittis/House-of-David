<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $services = [
            ['name' => 'Sunday Service'],
            ['name' => 'Wednesday Bible Study'],
            ['name' => 'Youth Group'],
            // Add more services as needed
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
