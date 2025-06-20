<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        $this->call([
            \Database\Seeders\ServiceSeeder::class,
            \Database\Seeders\RoleAndUserSeeder::class,
        ]);
    }
}
