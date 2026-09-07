<?php

namespace Database\Seeders;

use App\Models\Entity;
use Illuminate\Database\Seeder;

class EntitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $entities = [
            ['key' => '01', 'name' => 'Aguascalientes'],
            ['key' => '02', 'name' => 'Baja California'],
            ['key' => '03', 'name' => 'Baja California Sur'],
            ['key' => '04', 'name' => 'Campeche'],
            ['key' => '05', 'name' => 'Coahuila de Zaragoza'],
            ['key' => '06', 'name' => 'Colima'],
            ['key' => '07', 'name' => 'Chiapas'],
            ['key' => '08', 'name' => 'Chihuahua'],
            ['key' => '09', 'name' => 'Ciudad de México'],
            ['key' => '10', 'name' => 'Durango'],
            ['key' => '11', 'name' => 'Guanajuato'],
            ['key' => '12', 'name' => 'Guerrero'],
            ['key' => '13', 'name' => 'Hidalgo'],
            ['key' => '14', 'name' => 'Jalisco'],
            ['key' => '15', 'name' => 'México'],
            ['key' => '16', 'name' => 'Michoacán de Ocampo'],
            ['key' => '17', 'name' => 'Morelos'],
            ['key' => '18', 'name' => 'Nayarit'],
            ['key' => '19', 'name' => 'Nuevo León'],
            ['key' => '20', 'name' => 'Oaxaca'],
            ['key' => '21', 'name' => 'Puebla'],
            ['key' => '22', 'name' => 'Querétaro'],
            ['key' => '23', 'name' => 'Quintana Roo'],
            ['key' => '24', 'name' => 'San Luis Potosí'],
            ['key' => '25', 'name' => 'Sinaloa'],
            ['key' => '26', 'name' => 'Sonora'],
            ['key' => '27', 'name' => 'Tabasco'],
            ['key' => '28', 'name' => 'Tamaulipas'],
            ['key' => '29', 'name' => 'Tlaxcala'],
            ['key' => '30', 'name' => 'Veracruz de Ignacio de la Llave'],
            ['key' => '31', 'name' => 'Yucatán'],
            ['key' => '32', 'name' => 'Zacatecas'],
        ];

        foreach ($entities as $entity) {
            Entity::updateOrCreate(
                ['key' => $entity['key']],
                [
                    'name' => $entity['name'],
                    'regional_center' => '',
                    'bordering_entities' => []
                ]
            );
        }
    }
}