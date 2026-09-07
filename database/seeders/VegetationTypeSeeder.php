<?php

namespace Database\Seeders;

use App\Models\VegetationType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VegetationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vegetationTypes = [
            'Bosque de Encino',
            'Bosque de Encino-Pino',
            'Bosque de Galería',
            'Bosque de Mezquite',
            'Bosque de Oyamel',
            'Bosque de Pino',
            'Bosque de Pino-Encino',
            'Bosque de Táscate',
            'Bosque Mesófilo de Montaña',
            'Bosque de Cedro',
            'Bosque de Ahuehuete',
            'Selva Alta Perennifolia',
            'Selva Mediana Subperennifolia',
            'Selva Baja Caducifolia',
            'Matorral Desértico',
            'Matorral Xerófilo',
            'Pastizal Natural',
            'Manglar',
        ];

        foreach ($vegetationTypes as $name) {
            VegetationType::firstOrCreate([
                'name' => $name,
            ]);
        }
    }
}