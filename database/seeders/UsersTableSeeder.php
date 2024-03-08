<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'id' => '62cf85e2-c677-43eb-8bc5-c38d71db4114',
                'name' => 'manuel',
                'apellidos' => 'cerda',
                'activado' => 1,
                'visto' => 1,
                'rol' => 0,
                'email' => 'admin@fielgroup.com.mx',
                'email_verified_at' => NULL,
                'password' => '$2y$10$7j5OpS2kFWsqgLuqDxrsGO2nUcas4mSu5BTrwfYa2HoJqMwmT85cG',
                'password_plain' => '12345678',
                'api_token' => 'q4D38Y0G9wHrWKdOJPIltPjvCvKwVARm2yCIb2EgscI5GEGTMz4LtRRChIlC',
                'imagen_perfil' => NULL,
                'telefono' => NULL,
                'telefono_oficina' => NULL,
                'celular' => NULL,
                'celular2' => NULL,
                'titulo' => 'Dr.',
                'titulo_presenta' => NULL,
                'direccion_principal' => NULL,
                'remember_token' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2022-12-05 22:00:15',
                'updated_at' => '2022-12-05 22:00:15',
            )
        ));
        
        
    }
}