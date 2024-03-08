<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CatGenerosTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('cat_generos')->delete();
        
        \DB::table('cat_generos')->insert(array (
            0 => 
            array (
                'id' => 1,
                'nombre' => 'Hombre',
            ),
            1 => 
            array (
                'id' => 2,
                'nombre' => 'Mujer',
            ),
        ));
        
        
    }
}