<?php

namespace Database\Seeders;

use App\Models\RegionalCenter;
use Illuminate\Database\Seeder;

class RegionalCenterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $centers = [
            'Noroeste',
            'Noreste',
            'Occidente',
            'Centro-Norte',
            'Centro',
            'Golfo',
            'Sur',
            'Sureste',
        ];

        foreach ($centers as $center) {
            RegionalCenter::firstOrCreate([
                'name' => $center,
            ]);
        }
    }
}