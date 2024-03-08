<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CatArticuloOrigenesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('cat_articulo_origenes')->delete();

        \DB::table('cat_articulo_origenes')->insert(array (
            0 =>
            array (
                'id' => 1,
                'nombre' => 'Original Nacional',
            ),
            1 =>
            array (
                'id' => 2,
                'nombre' => 'Original Importado',
            ),
            2 =>
            array (
                'id' => 3,
                'nombre' => 'Seminuevo',
            ),
            3 =>
            array (
                'id' => 4,
                'nombre' => 'Chino',
            ),
            4 =>
            array (
                'id' => 5,
                'nombre' => 'Taiwán',
            ),
            5 =>
            array (
                'id' => 6,
                'nombre' => 'Misceláneos ',
            ),
            6 =>
            array (
                'id' => 7,
            'nombre' => 'Chinos DGR',
            ),
        ));


    }
}
