<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CatPresentacionesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('cat_presentaciones')->delete();
        
        \DB::table('cat_presentaciones')->insert(array (
            0 => 
            array (
                'id' => 1,
                'nombre' => 'Pieza',
                'deleted_at' => NULL,
                'codigo' => 'H87',
            ),
        ));
        
        
    }
}