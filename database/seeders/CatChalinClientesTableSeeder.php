<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CatChalinClientesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('cat_chalin_clientes')->delete();

        \DB::table('cat_chalin_clientes')->insert(array (
            0 =>
                array (
                    'nombre' => 'Constante',
                    'deleted_at' => NULL,
                    'id' => 1,
                ),
            1 =>
                array (
                    'nombre' => 'General',
                    'deleted_at' => NULL,
                    'id' => 2,
                ),
            2 =>
                array (
                    'nombre' => 'Mayoreo',
                    'deleted_at' => NULL,
                    'id' => 3,
                ),
            3 =>
                array (
                    'nombre' => 'Medio mayoreo',
                    'deleted_at' => NULL,
                    'id' => 4,
                ),
        ));
    }
}
