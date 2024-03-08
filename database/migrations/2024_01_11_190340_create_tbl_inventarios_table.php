<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Http\Traits\Uuids;

class CreateTblInventariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_inventarios', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_producto');
            $table->uuid('id_sucursal');
            $table->decimal('cantidad', 10, 2);
            $table->decimal('precio', 10, 2);
            $table->decimal('maximo', 10, 2);
            $table->decimal('minimo', 10, 2);
            $table->decimal('fraccion', 10, 2);
            $table->decimal('capacidad', 10, 2);
            $table->decimal('inventario', 10, 2);
            $table->integer('compuesto');
            $table->integer('id_estatus');
            $table->string('clave');
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
        Schema::dropIfExists('tbl_inventarios');
    }
}
