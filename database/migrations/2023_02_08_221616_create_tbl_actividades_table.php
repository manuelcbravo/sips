<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Http\Traits\Uuids;

class CreateTblActividadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_actividades', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_lead')->nullable();
            $table->uuid('id_asesor')->nullable();
            $table->uuid('id_usuario_reg')->nullable();
            $table->uuid('id_usuario_asignado')->nullable();
            $table->timestamp('fecha_hora_inicio');
            $table->timestamp('fecha_hora_fin')->nullable();
            $table->string('instruccion')->nullable();
            $table->integer('id_actividad')->nullable();
            $table->string('des_actividad')->nullable();
            $table->integer('finalizar')->nullable()->default('0');
            $table->uuid('id_tbl_seguimiento')->nullable();
            $table->uuid('id_tbl_lugar')->nullable();
            $table->string('otro_lugar')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_actividades');
    }
}
