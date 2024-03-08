<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class EmpresasTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('empresas')->delete();
        
        \DB::table('empresas')->insert(array (
            0 => 
            array (
                'id' => '302da828-0fdf-4bbc-a7f2-2a100979daf4',
                'nombre' => 'DORA ELENA ROMERO CORTES',
                'rfc' => 'ROCD760229DL1',
                'calle' => 'AV. 21 DE MARZO NORTE',
                'cp' => '43630',
                'colonia' => 'INSURGENTES',
                'estado' => 'HIDALGO',
                'localidad' => 'TULANCINGO DE BRAVO',
                'municipio' => 'TULANCINGO DE BRAVO',
                'numeroExterior' => '1406',
                'numeroInterior' => NULL,
                'certificado' => NULL,
                'archivokey' => NULL,
                'clave' => NULL,
                'serie' => 'Y',
                'mail' => NULL,
                'llaveprivada' => NULL,
                'tipoFactura' => NULL,
                'regimenfiscal' => 612,
                'almacen' => '1',
                'latitud' => '200.815.169',
                'longitud' => '-98.367.278',
            ),
        ));
        
        
    }
}