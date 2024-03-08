<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Http\Traits\Uuids;

class CreateTblInventarioHistoricosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_inventario_historicos', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_producto');
            $table->uuid('id_sucursal');
            $table->uuid('id_proveedor');
            $table->uuid('id_pedido');
            $table->uuid('id_usuario_reg');
            $table->decimal('inventario_inicial', 10, 2);
            $table->decimal('inventario_final', 10, 2);
            $table->decimal('entrada', 10, 2);
            $table->decimal('salida', 10, 2);
            $table->decimal('fraccion', 10, 2);
            $table->decimal('capacidad', 10, 2);
            $table->decimal('inventario', 10, 2);
            $table->integer('ultimo');
            $table->string('id_tipo_movimiento');
            $table->string('clave');
            $table->string('comentario');
            $table->string('orden_comprea');
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
        Schema::dropIfExists('tbl_inventario_historicos');
    }
}
