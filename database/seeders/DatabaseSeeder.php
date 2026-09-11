<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            VegetationTypeSeeder::class,
            EntitySeeder::class,
            RegionalCenterSeeder::class,
            MunicipalitySeeder::class
        ]);
    }
}