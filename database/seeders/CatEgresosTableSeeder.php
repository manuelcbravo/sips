<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CatEgresosTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('cat_egresos')->delete();
        
        \DB::table('cat_egresos')->insert(array (
            0 => 
            array (
                'id' => 1,
                'nombre' => 'PAPELERIA',
            ),
            1 => 
            array (
                'id' => 2,
                'nombre' => 'SUMINISTROS',
            ),
            2 => 
            array (
                'id' => 3,
                'nombre' => 'VIATICOS',
            ),
            3 => 
            array (
                'id' => 4,
                'nombre' => 'ALIMENTOS',
            ),
        ));
        
        
    }
}