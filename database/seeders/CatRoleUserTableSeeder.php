<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CatRoleUserTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('cat_role_user')->delete();
        
        \DB::table('cat_role_user')->insert(array (
            0 => 
            array (
                'id' => 1,
                'cat_role_id' => 0,
                'user_id' => '62cf85e2-c677-43eb-8bc5-c38d71db4114',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            
        ));
        
        
    }
}