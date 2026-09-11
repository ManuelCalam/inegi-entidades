<?php

namespace Database\Seeders;

use App\Models\Entity;
use App\Models\Municipality;
use Illuminate\Database\Seeder;

class MunicipalitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $municipalitiesByEntity = [
            // 01. Aguascalientes
            '01' => [
                ['key' => '001', 'name' => 'Aguascalientes'],
                ['key' => '002', 'name' => 'Asientos'],
                ['key' => '003', 'name' => 'Calvillo'],
                ['key' => '004', 'name' => 'Cosío'],
                ['key' => '005', 'name' => 'Jesús María'],
                ['key' => '006', 'name' => 'Pabellón de Arteaga'],
            ],
            // 02. Baja California
            '02' => [
                ['key' => '001', 'name' => 'Ensenada'],
                ['key' => '002', 'name' => 'Mexicali'],
                ['key' => '003', 'name' => 'Tecate'],
                ['key' => '004', 'name' => 'Tijuana'],
                ['key' => '005', 'name' => 'Playas de Rosarito'],
                ['key' => '006', 'name' => 'San Quintín'],
            ],
            // 03. Baja California Sur
            '03' => [
                ['key' => '001', 'name' => 'Comondú'],
                ['key' => '002', 'name' => 'Mulegé'],
                ['key' => '003', 'name' => 'La Paz'],
                ['key' => '008', 'name' => 'Los Cabos'],
                ['key' => '009', 'name' => 'Loreto'],
            ],
            // 04. Campeche
            '04' => [
                ['key' => '001', 'name' => 'Calkiní'],
                ['key' => '002', 'name' => 'Campeche'],
                ['key' => '003', 'name' => 'Carmen'],
                ['key' => '004', 'name' => 'Champotón'],
                ['key' => '005', 'name' => 'Hecelchakán'],
                ['key' => '006', 'name' => 'Hopelchén'],
            ],
            // 05. Coahuila de Zaragoza
            '05' => [
                ['key' => '001', 'name' => 'Abasolo'],
                ['key' => '002', 'name' => 'Acuña'],
                ['key' => '003', 'name' => 'Allende'],
                ['key' => '004', 'name' => 'Arteaga'],
                ['key' => '018', 'name' => 'Monclova'],
                ['key' => '030', 'name' => 'Saltillo'],
                ['key' => '035', 'name' => 'Torreón'],
            ],
            // 06. Colima
            '06' => [
                ['key' => '001', 'name' => 'Armería'],
                ['key' => '002', 'name' => 'Colima'],
                ['key' => '003', 'name' => 'Comala'],
                ['key' => '004', 'name' => 'Coquimatlán'],
                ['key' => '007', 'name' => 'Manzanillo'],
                ['key' => '010', 'name' => 'Villa de Álvarez'],
            ],
            // 07. Chiapas
            '07' => [
                ['key' => '019', 'name' => 'Chiapa de Corzo'],
                ['key' => '027', 'name' => 'Comitán de Domínguez'],
                ['key' => '065', 'name' => 'Palenque'],
                ['key' => '078', 'name' => 'San Cristóbal de las Casas'],
                ['key' => '089', 'name' => 'Tapachula'],
                ['key' => '101', 'name' => 'Tuxtla Gutiérrez'],
            ],
            // 08. Chihuahua
            '08' => [
                ['key' => '017', 'name' => 'Chihuahua'],
                ['key' => '019', 'name' => 'Delicias'],
                ['key' => '032', 'name' => 'Hidalgo del Parral'],
                ['key' => '037', 'name' => 'Juárez'],
                ['key' => '011', 'name' => 'Cuauhtémoc'],
                ['key' => '005', 'name' => 'Balleza'],
            ],
            // 09. Ciudad de México
            '09' => [
                ['key' => '002', 'name' => 'Azcapotzalco'],
                ['key' => '003', 'name' => 'Coyoacán'],
                ['key' => '005', 'name' => 'Gustavo A. Madero'],
                ['key' => '007', 'name' => 'Iztapalapa'],
                ['key' => '010', 'name' => 'Álvaro Obregón'],
                ['key' => '015', 'name' => 'Cuauhtémoc'],
            ],
            // 10. Durango
            '10' => [
                ['key' => '005', 'name' => 'Durango'],
                ['key' => '007', 'name' => 'Gómez Palacio'],
                ['key' => '012', 'name' => 'Lerdo'],
                ['key' => '023', 'name' => 'Pueblo Nuevo'],
                ['key' => '038', 'name' => 'Vicente Guerrero'],
                ['key' => '013', 'name' => 'Mapimí'],
            ],
            // 11. Guanajuato
            '11' => [
                ['key' => '015', 'name' => 'Guanajuato'],
                ['key' => '017', 'name' => 'Irapuato'],
                ['key' => '020', 'name' => 'León'],
                ['key' => '023', 'name' => 'San Miguel de Allende'],
                ['key' => '027', 'name' => 'Salamanca'],
                ['key' => '007', 'name' => 'Celaya'],
            ],
            // 12. Guerrero
            '12' => [
                ['key' => '001', 'name' => 'Acapulco de Juárez'],
                ['key' => '029', 'name' => 'Chilpancingo de los Bravo'],
                ['key' => '035', 'name' => 'Iguala de la Independencia'],
                ['key' => '038', 'name' => 'Zihuatanejo de Azueta'],
                ['key' => '055', 'name' => 'Taxco de Alarcón'],
                ['key' => '028', 'name' => 'Chilapa de Álvarez'],
            ],
            // 13. Hidalgo
            '13' => [
                ['key' => '048', 'name' => 'Pachuca de Soto'],
                ['key' => '076', 'name' => 'Tula de Allende'],
                ['key' => '077', 'name' => 'Tulancingo de Bravo'],
                ['key' => '051', 'name' => 'Mineral de la Reforma'],
                ['key' => '028', 'name' => 'Huejutla de Reyes'],
                ['key' => '030', 'name' => 'Ixmiquilpan'],
            ],
            // 14. Jalisco
            '14' => [
                ['key' => '039', 'name' => 'Guadalajara'],
                ['key' => '120', 'name' => 'Zapopan'],
                ['key' => '098', 'name' => 'Tlaquepaque'],
                ['key' => '101', 'name' => 'Tlajomulco de Zúñiga'],
                ['key' => '067', 'name' => 'Puerto Vallarta'],
                ['key' => '070', 'name' => 'Tonalá'],
            ],
            // 15. México
            '15' => [
                ['key' => '033', 'name' => 'Ecatepec de Morelos'],
                ['key' => '057', 'name' => 'Naucalpan de Juárez'],
                ['key' => '058', 'name' => 'Nezahualcóyotl'],
                ['key' => '106', 'name' => 'Toluca'],
                ['key' => '054', 'name' => 'Metepec'],
                ['key' => '104', 'name' => 'Tlalnepantla de Baz'],
            ],
            // 16. Michoacán de Ocampo
            '16' => [
                ['key' => '053', 'name' => 'Morelia'],
                ['key' => '102', 'name' => 'Uruapan'],
                ['key' => '108', 'name' => 'Zamora'],
                ['key' => '047', 'name' => 'Lázaro Cárdenas'],
                ['key' => '066', 'name' => 'Pátzcuaro'],
                ['key' => '120', 'name' => 'Zitácuaro'],
            ],
            // 17. Morelos
            '17' => [
                ['key' => '006', 'name' => 'Cuernavaca'],
                ['key' => '007', 'name' => 'Cuautla'],
                ['key' => '011', 'name' => 'Jiutepec'],
                ['key' => '024', 'name' => 'Temixco'],
                ['key' => '030', 'name' => 'Yautepec'],
                ['key' => '012', 'name' => 'Jojutla'],
            ],
            // 18. Nayarit
            '18' => [
                ['key' => '008', 'name' => 'Compostela'],
                ['key' => '017', 'name' => 'Tepic'],
                ['key' => '018', 'name' => 'Tuxpan'],
                ['key' => '020', 'name' => 'Bahía de Banderas'],
                ['key' => '010', 'name' => 'Ixtlán del Río'],
                ['key' => '013', 'name' => 'San Blas'],
            ],
            // 19. Nuevo León
            '19' => [
                ['key' => '018', 'name' => 'García'],
                ['key' => '019', 'name' => 'San Pedro Garza García'],
                ['key' => '026', 'name' => 'Guadalupe'],
                ['key' => '039', 'name' => 'Monterrey'],
                ['key' => '046', 'name' => 'San Nicolás de los Garza'],
                ['key' => '048', 'name' => 'Santa Catarina'],
            ],
            // 20. Oaxaca
            '20' => [
                ['key' => '067', 'name' => 'Oaxaca de Juárez'],
                ['key' => '184', 'name' => 'Salina Cruz'],
                ['key' => '293', 'name' => 'San Juan Bautista Tuxtepec'],
                ['key' => '385', 'name' => 'Santa Cruz Xoxocotlán'],
                ['key' => '025', 'name' => 'Juchitán de Zaragoza'],
                ['key' => '030', 'name' => 'Huatulco'],
            ],
            // 21. Puebla
            '21' => [
                ['key' => '114', 'name' => 'Puebla'],
                ['key' => '156', 'name' => 'Tehuacán'],
                ['key' => '119', 'name' => 'San Andrés Cholula'],
                ['key' => '140', 'name' => 'San Pedro Cholula'],
                ['key' => '132', 'name' => 'San Martin Texmelucan'],
                ['key' => '019', 'name' => 'Atlixco'],
            ],
            // 22. Querétaro
            '22' => [
                ['key' => '006', 'name' => 'Ezequiel Montes'],
                ['key' => '011', 'name' => 'El Marqués'],
                ['key' => '014', 'name' => 'Querétaro'],
                ['key' => '016', 'name' => 'San Juan del Río'],
                ['key' => '008', 'name' => 'Jalpan de Serra'],
                ['key' => '005', 'name' => 'Corregidora'],
            ],
            // 23. Quintana Roo
            '23' => [
                ['key' => '001', 'name' => 'Cozumel'],
                ['key' => '002', 'name' => 'Felipe Carrillo Puerto'],
                ['key' => '003', 'name' => 'Isla Mujeres'],
                ['key' => '004', 'name' => 'Othón P. Blanco'],
                ['key' => '005', 'name' => 'Benito Juárez'],
                ['key' => '008', 'name' => 'Solidaridad'],
            ],
            // 24. San Luis Potosí
            '24' => [
                ['key' => '013', 'name' => 'Ciudad Valles'],
                ['key' => '028', 'name' => 'San Luis Potosí'],
                ['key' => '035', 'name' => 'Soledad de Graciano Sánchez'],
                ['key' => '020', 'name' => 'Matehuala'],
                ['key' => '024', 'name' => 'Rioverde'],
                ['key' => '037', 'name' => 'Tamazunchale'],
            ],
            // 25. Sinaloa
            '25' => [
                ['key' => '001', 'name' => 'Ahome'],
                ['key' => '006', 'name' => 'Culiacán'],
                ['key' => '010', 'name' => 'El Fuerte'],
                ['key' => '011', 'name' => 'Guasave'],
                ['key' => '012', 'name' => 'Mazatlán'],
                ['key' => '018', 'name' => 'Navolato'],
            ],
            // 26. Sonora
            '26' => [
                ['key' => '018', 'name' => 'Cajeme'],
                ['key' => '029', 'name' => 'Guaymas'],
                ['key' => '030', 'name' => 'Hermosillo'],
                ['key' => '042', 'name' => 'Nogales'],
                ['key' => '055', 'name' => 'San Luis Río Colorado'],
                ['key' => '048', 'name' => 'Puerto Peñasco'],
            ],
            // 27. Tabasco
            '27' => [
                ['key' => '003', 'name' => 'Cárdenas'],
                ['key' => '004', 'name' => 'Centla'],
                ['key' => '008', 'name' => 'Centro'],
                ['key' => '009', 'name' => 'Comalcalco'],
                ['key' => '012', 'name' => 'Macuspana'],
                ['key' => '014', 'name' => 'Nacajuca'],
            ],
            // 28. Tamaulipas
            '28' => [
                ['key' => '009', 'name' => 'Ciudad Madero'],
                ['key' => '022', 'name' => 'Matamoros'],
                ['key' => '027', 'name' => 'Nuevo Laredo'],
                ['key' => '032', 'name' => 'Reynosa'],
                ['key' => '038', 'name' => 'Tampico'],
                ['key' => '041', 'name' => 'Victoria'],
            ],
            // 29. Tlaxcala
            '29' => [
                ['key' => '005', 'name' => 'Apizaco'],
                ['key' => '018', 'name' => 'Huamantla'],
                ['key' => '033', 'name' => 'Tlaxcala'],
                ['key' => '010', 'name' => 'Chiautempan'],
                ['key' => '008', 'name' => 'Calpulalpan'],
                ['key' => '043', 'name' => 'Tlaxco'],
            ],
            // 30. Veracruz de Ignacio de la Llave
            '30' => [
                ['key' => '044', 'name' => 'Coatzacoalcos'],
                ['key' => '087', 'name' => 'Xalapa'],
                ['key' => '118', 'name' => 'Orizaba'],
                ['key' => '131', 'name' => 'Poza Rica de Hidalgo'],
                ['key' => '193', 'name' => 'Veracruz'],
                ['key' => '039', 'name' => 'Córdoba'],
            ],
            // 31. Yucatán
            '31' => [
                ['key' => '050', 'name' => 'Mérida'],
                ['key' => '059', 'name' => 'Progreso'],
                ['key' => '091', 'name' => 'Tizimín'],
                ['key' => '102', 'name' => 'Valladolid'],
                ['key' => '044', 'name' => 'Kanasín'],
                ['key' => '101', 'name' => 'Umán'],
            ],
            // 32. Zacatecas
            '32' => [
                ['key' => '010', 'name' => 'Fresnillo'],
                ['key' => '017', 'name' => 'Guadalupe'],
                ['key' => '020', 'name' => 'Jerez'],
                ['key' => '056', 'name' => 'Zacatecas'],
                ['key' => '034', 'name' => 'Nochistlán de Mejía'],
                ['key' => '039', 'name' => 'Río Grande'],
            ],
        ];

        foreach ($municipalitiesByEntity as $entityKey => $municipalities) {
            $entity = Entity::where('key', $entityKey)->first();

            if (! $entity) {
                continue;
            }

            foreach ($municipalities as $municipality) {
                Municipality::updateOrCreate(
                    [
                        'entity_id' => $entity->id,
                        'key' => $municipality['key'],
                    ],
                    [
                        'name' => $municipality['name'],
                    ]
                );
            }
        }
    }
}