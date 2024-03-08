<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Http\Traits\Uuids;
use Illuminate\Database\Eloquent\SoftDeletes; //línea necesaria

class CreateTblArticulosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_articulos', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('articulo')->nullable();
            $table->string('articulo_limpio')->nullable();
            $table->string('id_linea')->nullable();
            $table->string('id_marca')->nullable();
            $table->integer('id_clasificacion')->nullable();
            $table->integer('id_unidad_medida')->nullable();
            $table->integer('capacidad')->nullable();
            $table->string('id_presentacion')->nullable();
            $table->float('precio')->nullable();
            $table->float('precio_prom_mes')->nullable();
            $table->integer('importacion')->default(0)->comment('0 no importado, 1 importado ');
            $table->text('descripcion')->nullable();
            $table->timestamp('ultima_venta')->nullable()->timezone(false);
            $table->uuid('sucursal')->nullable();
            $table->integer('venta_total')->nullable();
            $table->integer('venta_mes')->nullable();
            $table->integer('autocodigo')->nullable();
            $table->integer('ensanblado_en_linea')->default(0)->comment('0 no importado, 1 importado ');
            $table->string('clave_prodserv')->nullable();
            $table->text('observacion')->nullable();
            $table->string('imagen')->nullable();
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
        Schema::dropIfExists('tbl_articulos');
    }
}
