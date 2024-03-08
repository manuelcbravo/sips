<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CatIngresosTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('cat_ingresos')->delete();
        
        \DB::table('cat_ingresos')->insert(array (
            0 => 
            array (
                'id' => 1,
                'nombre' => 'PRESTAMO',
            ),
        ));
        
        
    }
}