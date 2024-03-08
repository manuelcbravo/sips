<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblComprasPagosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_compras_pagos', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_usuario_registro');
            $table->uuid('id_compra')->nullable();
            $table->integer('id_pago_metodo')->nullable();
            $table->integer('folio');
            $table->integer('consecutivo')->nullable(); 
            $table->double('cantidad', 8, 2)->nullable();
            $table->string('clave_rastreo')->nullable();
            $table->text('comentario')->nullable();
            $table->double('efectivo', 8, 2)->nullable();
            $table->double('banco', 8, 2)->nullable();
            $table->date('fecha')->nullable();
            $table->date('fecha_aplicacion')->nullable();
            $table->text('img_recibo')->nullable();
            $table->text('img_comprobantes')->nullable();
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
        Schema::dropIfExists('tbl_compras_pagos');
    }
}
