<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CatDocumentosTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('cat_documentos')->delete();
        
        \DB::table('cat_documentos')->insert(array (
            0 => 
            array (
                'id' => 1,
                'nombre' => 'Comprobante de domicilio',
                'idioma' => 'es',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
            'nombre' => 'Identeficación oficial (adelante)',
                'idioma' => 'es',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
            'nombre' => 'Identeficación oficial (atras)',
                'idioma' => 'es',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}