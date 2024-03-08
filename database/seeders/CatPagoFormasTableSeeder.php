<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CatPagoFormasTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('cat_pago_formas')->delete();
        
        \DB::table('cat_pago_formas')->insert(array (
            0 => 
            array (
                'id' => 1,
                'nombre' => 'Diario',
                'dias' => 1,
            ),
            1 => 
            array (
                'id' => 2,
                'nombre' => 'Semanal',
                'dias' => 7,
            ),
            2 => 
            array (
                'id' => 3,
                'nombre' => 'Quincenal',
                'dias' => 15,
            ),
            3 => 
            array (
                'id' => 4,
                'nombre' => 'Mensual',
                'dias' => 30,
            ),
        ));
        
        
    }
}