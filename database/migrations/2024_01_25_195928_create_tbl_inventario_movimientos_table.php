<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Http\Traits\Uuids;

class CreateTblInventarioMovimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_inventario_movimientos', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_sucursal');
            $table->uuid('id_articulo')->nullable();
            $table->uuid('id_sucursal_traspaso')->nullable();
            $table->uuid('id_sucursal_almacen')->nullable();
            $table->uuid('id_usuario_reg');
            $table->integer('id_movimiento');
            $table->integer('entrada')->default(0);
            $table->integer('salida')->default(0);
            $table->integer('inv_inicial')->default(0);
            $table->integer('inv_final')->default(0);
            $table->text('comentario')->nullable();
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
        Schema::dropIfExists('tbl_inventario_movimientos');
    }
}
