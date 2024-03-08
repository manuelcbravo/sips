<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CatRolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('cat_roles')->delete();
        
        \DB::table('cat_roles')->insert(array (
            0 => 
            array (
                'id' => 0,
                'nombre' => 'Desarrollo',
                'descripcion' => 'Desarrollo',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 1,
                'nombre' => 'Super Administrador',
                'descripcion' => 'admin',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 2,
                'nombre' => 'Administrador general',
                'descripcion' => '',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 3,
                'nombre' => 'Vendedor',
                'descripcion' => '',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 4,
                'nombre' => 'Cajero',
                'descripcion' => '',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'id' => 5,
                'nombre' => 'Contador',
                'descripcion' => '',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'id' => 6,
                'nombre' => 'Aux general',
                'descripcion' => '',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            7 => 
            array (
                'id' => 7,
                'nombre' => 'Compras',
                'descripcion' => '',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            8 => 
            array (
                'id' => 8,
                'nombre' => 'Almacen',
                'descripcion' => '',
                'created_at' => NULL,
                'updated_at' => NULL,
            )
        ));
        
        
    }
}