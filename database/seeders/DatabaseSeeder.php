<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(UsersTableSeeder::class);
        $this->call(CatEstadosTableSeeder::class);
        $this->call(CatMunicipiosTableSeeder::class);
        $this->call(CatDocumentosTableSeeder::class);
        $this->call(CatMedioContactosTableSeeder::class);
        $this->call(CatPagoFormasTableSeeder::class);
        $this->call(CatPagosConceptosTableSeeder::class);
        $this->call(CatPagosMetodosTableSeeder::class);
        $this->call(CatEstadoCivilsTableSeeder::class);
        $this->call(CatRolesTableSeeder::class);
        $this->call(CatRoleUserTableSeeder::class);

        $this->call(CatIngresosTableSeeder::class);
        $this->call(CatEgresosTableSeeder::class);
        $this->call(CatGenerosTableSeeder::class);
        $this->call(CatClienteTiposTableSeeder::class);
        $this->call(CatLineasTableSeeder::class);
        $this->call(CatMarcasTableSeeder::class);
        $this->call(CatRegimenFiscalesTableSeeder::class);
        $this->call(EmpresasTableSeeder::class);
        $this->call(CatUsoCfdisTableSeeder::class);
        $this->call(CatUMedidasTableSeeder::class);
        $this->call(CatArticuloOrigenesTableSeeder::class);
        $this->call(CatPresentacionesTableSeeder::class);
        $this->call(CatMovimientosTableSeeder::class);
    }
}
