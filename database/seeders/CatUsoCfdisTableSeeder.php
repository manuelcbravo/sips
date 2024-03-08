<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CatUsoCfdisTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('cat_uso_cfdis')->delete();
        
        \DB::table('cat_uso_cfdis')->insert(array (
            0 => 
            array (
                'id' => 'D01',
                'nombre' => 'D01-Honorarios médicos, dentales y gastos hospitalarios.',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 'D02',
                'nombre' => 'D02-Gastos médicos por incapacidad o discapacidad',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 'D03',
                'nombre' => 'D03-Gastos funerales.',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 'D04',
                'nombre' => 'D04-Donativos.',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 'D05',
            'nombre' => 'D05-Intereses reales efectivamente pagados por créditos hipotecarios (casa habitación).',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 'D06',
                'nombre' => 'D06-Aportaciones voluntarias al SAR.',
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => 'D07',
                'nombre' => 'D07-Primas por seguros de gastos médicos.',
                'deleted_at' => NULL,
            ),
            7 => 
            array (
                'id' => 'D08',
                'nombre' => 'D08-Gastos de transportación escolar obligatoria.',
                'deleted_at' => NULL,
            ),
            8 => 
            array (
                'id' => 'D09',
                'nombre' => 'D09-Depósitos en cuentas para el ahorro, primas que tengan como base planes de pensiones.',
                'deleted_at' => NULL,
            ),
            9 => 
            array (
                'id' => 'D10',
            'nombre' => 'D10-Pagos por servicios educativos (colegiaturas)',
                'deleted_at' => NULL,
            ),
            10 => 
            array (
                'id' => 'G01',
                'nombre' => 'G01-Adquisición de mercancias',
                'deleted_at' => NULL,
            ),
            11 => 
            array (
                'id' => 'G02',
                'nombre' => 'G02-Devoluciones, descuentos o bonificaciones',
                'deleted_at' => NULL,
            ),
            12 => 
            array (
                'id' => 'G03',
                'nombre' => 'G03-Gastos en general',
                'deleted_at' => NULL,
            ),
            13 => 
            array (
                'id' => 'I01',
                'nombre' => 'I01-Construcciones',
                'deleted_at' => NULL,
            ),
            14 => 
            array (
                'id' => 'I02',
                'nombre' => 'I02-Mobilario y equipo de oficina por inversiones',
                'deleted_at' => NULL,
            ),
            15 => 
            array (
                'id' => 'I03',
                'nombre' => 'I03-Equipo de transporte',
                'deleted_at' => NULL,
            ),
            16 => 
            array (
                'id' => 'I04',
                'nombre' => 'I04-Equipo de computo y accesorios',
                'deleted_at' => NULL,
            ),
            17 => 
            array (
                'id' => 'I05',
                'nombre' => 'I05-Dados, troqueles, moldes, matrices y herramental',
                'deleted_at' => NULL,
            ),
            18 => 
            array (
                'id' => 'I06',
                'nombre' => 'I06-Comunicaciones telefónicas',
                'deleted_at' => NULL,
            ),
            19 => 
            array (
                'id' => 'I07',
                'nombre' => 'I07-Comunicaciones satelitales',
                'deleted_at' => NULL,
            ),
            20 => 
            array (
                'id' => 'I08',
                'nombre' => 'I08-Otra maquinaria y equipo',
                'deleted_at' => NULL,
            ),
            21 => 
            array (
                'id' => 'P01',
                'nombre' => 'P01-Por definir',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}