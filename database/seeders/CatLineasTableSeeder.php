<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CatLineasTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('cat_lineas')->delete();
        
        \DB::table('cat_lineas')->insert(array (
            0 => 
            array (
                'linea' => 'A',
                'nombre' => 'MOTOR                                             ',
                'deleted_at' => NULL,
                'id' => 1,
            ),
            1 => 
            array (
                'linea' => 'B',
                'nombre' => 'COMBUSTIBLE                                       ',
                'deleted_at' => NULL,
                'id' => 2,
            ),
            2 => 
            array (
                'linea' => 'C',
                'nombre' => 'ESCAPE Y RADIADOR                                 ',
                'deleted_at' => NULL,
                'id' => 3,
            ),
            3 => 
            array (
                'linea' => 'D',
                'nombre' => 'ELECTRICO DE MOTOR                                ',
                'deleted_at' => NULL,
                'id' => 4,
            ),
            4 => 
            array (
                'linea' => 'E',
                'nombre' => 'ELECTRICO DE CARROCERIA                           ',
                'deleted_at' => NULL,
                'id' => 5,
            ),
            5 => 
            array (
                'linea' => 'F',
                'nombre' => 'TREN DE POTENCIA                                  ',
                'deleted_at' => NULL,
                'id' => 6,
            ),
            6 => 
            array (
                'linea' => 'G',
                'nombre' => 'EJE Y SUSPENSION                                  ',
                'deleted_at' => NULL,
                'id' => 7,
            ),
            7 => 
            array (
                'linea' => 'H',
                'nombre' => 'FRENOS                                            ',
                'deleted_at' => NULL,
                'id' => 8,
            ),
            8 => 
            array (
                'linea' => 'I',
                'nombre' => 'DIRECCION                                         ',
                'deleted_at' => NULL,
                'id' => 9,
            ),
            9 => 
            array (
                'linea' => 'J',
            'nombre' => 'CARROCERIA (DELANTY TOLDO)                        ',
                'deleted_at' => NULL,
                'id' => 10,
            ),
            10 => 
            array (
                'linea' => 'K',
            'nombre' => 'CARROCERIA (LATERAL Y TRASERA)                    ',
                'deleted_at' => NULL,
                'id' => 11,
            ),
            11 => 
            array (
                'linea' => 'L              ',
            'nombre' => 'ASIENTOS (DELANTEROS Y TRASEROS)                  ',
                'deleted_at' => NULL,
                'id' => 12,
            ),
            12 => 
            array (
                'linea' => 'M',
                'nombre' => 'MISELAMEOS                                        ',
                'deleted_at' => NULL,
                'id' => 13,
            ),
            13 => 
            array (
                'linea' => 'N',
                'nombre' => 'QUIMICOS Y LUBRICANTES                            ',
                'deleted_at' => NULL,
                'id' => 14,
            ),
            14 => 
            array (
                'linea' => 'O              ',
                'nombre' => 'ACCESORIOS                                        ',
                'deleted_at' => NULL,
                'id' => 15,
            ),
            15 => 
            array (
                'linea' => 'SYS',
                'nombre' => 'Línea general',
                'deleted_at' => NULL,
                'id' => 16,
            ),
        ));
        
        
    }
}