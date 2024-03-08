<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CatPagosConceptosTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('cat_pagos_conceptos')->delete();
        
        \DB::table('cat_pagos_conceptos')->insert(array (
            0 => 
            array (
                'id' => 2,
                'nombre' => 'COMISIÓN POR APERTURA DE CRÉDITO',
                'detalle' => 'ABONO NORMAL',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 3,
                'nombre' => 'APORTACIÓN ADICIONAL',
                'detalle' => '',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 4,
                'nombre' => 'DIFERENCIA DE SALDOS',
                'detalle' => 'PAGO DEL CONTADO DEL LOTE',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 5,
            'nombre' => 'PAGO PARCIALIDAD(INTERES Y CAPITAL)',
                'detalle' => '',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 6,
                'nombre' => 'PAGO INTERES MORATORIO',
                'detalle' => '',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'id' => 7,
                'nombre' => 'CONDONACIÓN',
                'detalle' => NULL,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'id' => 1,
                'nombre' => 'PROTECCIÓN DE SEGURO DE CRÉDITO',
                'detalle' => 'abono',
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'nombre' => 'PAGO DE MULTAS',
                'detalle' => NULL,
                'deleted_at' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}