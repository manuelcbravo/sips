<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Http\Traits\Uuids;

class CreateTblComprasDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_compras_detalles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_compra');
            $table->float('cantidad');
            $table->string('unidad');
            $table->string('no_identificacion');
            $table->string('descripcion');
            $table->float('valor_unitario');
            $table->float('importe');
            $table->float('impuestos');
            $table->string('clave_prod_serv');
            $table->string('clave_unidad');
            $table->string('objeto_imp');
            $table->integer('cantidad_det');
            $table->integer('id_estatus')->comment('0 no inventario, 1 inventario');
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
        Schema::dropIfExists('tbl_compras_detalles');
    }
}
