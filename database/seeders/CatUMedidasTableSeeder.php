<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CatUMedidasTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('cat_u_medidas')->delete();
        
        \DB::table('cat_u_medidas')->insert(array (
            0 => 
            array (
                'id' => 1,
                'nombre' => 'gr.',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'nombre' => 'kg.',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'nombre' => 'ml.',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'nombre' => 'lt.',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'nombre' => 'pza.',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}