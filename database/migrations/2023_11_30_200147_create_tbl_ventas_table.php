<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Http\Traits\Uuids;
use Illuminate\Database\Eloquent\SoftDeletes; //línea necesaria

class CreateTblVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_ventas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('sucursal')->nullable();
            $table->uuid('id_usuario_reg')->nullable();
            $table->uuid('id_cliente')->nullable();
            $table->dateTime('fecha_venta'); // Cambiado a dateTime para incluir fecha y hora
            $table->decimal('total', 10, 2);
            $table->decimal('impuestos', 10, 2);
            $table->decimal('descuento', 10, 2)->default(0);
            $table->decimal('descuento_por', 10, 2)->default(0);
            $table->integer('ticket')->nullable();
            $table->integer('id_estatus')->nullable();
            $table->string('seudonimo')->nullable();
            $table->integer('num_productos')->nullable();
            $table->boolean('facturable')->default(false);
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
        Schema::dropIfExists('tbl_ventas');
    }
}
