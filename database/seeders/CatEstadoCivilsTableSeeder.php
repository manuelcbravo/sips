<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CatEstadoCivilsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('cat_estado_civils')->delete();
        
        \DB::table('cat_estado_civils')->insert(array (
            0 => 
            array (
                'id' => 1,
                'nombre' => 'Casado',
            ),
            1 => 
            array (
                'id' => 2,
                'nombre' => 'Divorciado',
            ),
            2 => 
            array (
                'id' => 3,
                'nombre' => 'Soltero',
            ),
            3 => 
            array (
                'id' => 4,
                'nombre' => 'Viudo',
            ),
            4 => 
            array (
                'id' => 5,
                'nombre' => 'Unión libre',
            ),
            5 => 
            array (
                'id' => 6,
                'nombre' => 'Separado',
            ),
        ));
        
        
    }
}