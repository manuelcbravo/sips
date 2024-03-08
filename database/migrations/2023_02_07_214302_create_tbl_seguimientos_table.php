<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Http\Traits\Uuids;

class CreateTblSeguimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_seguimientos', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_lead');
            $table->uuid('id_usuario_reg');
            $table->timestamp('fecha');
            $table->longText('comentario')->nullable();
            $table->integer('id_cat_medio_contactos')->nullable();
            $table->integer('contesto')->nullable();
            $table->timestamp('fecha_seguimiento')->nullable();
            $table->longText('acuerdo')->nullable();
            $table->string('id_llamada')->nullable();
            $table->string('numero')->nullable();
            $table->json('detalle_llamada')->nullable();
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
        Schema::dropIfExists('tbl_seguimientos');
    }
}
