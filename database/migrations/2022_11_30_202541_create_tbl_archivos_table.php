<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Http\Traits\Uuids;


class CreateTblArchivosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_archivos', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nombre');
            $table->string('nombre_original')->nullable();
            $table->string('direccion');
            $table->text('descripcion')->nullable();
            $table->integer('id_tipo')->nullable();
            $table->uuid('id_usuario_reg');
            $table->string('tamano')->nullable();
            $table->string('tipo');
            $table->uuid('id_asociado');
            $table->string('id_cat_folder_personal')->default(0);
            $table->integer('id_cat_documento')->default(0);
            $table->string('tabla');
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
        Schema::dropIfExists('tbl_archivos');
    }
}
