<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Http\Traits\Uuids;

class CreateTblInventarioSucursalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_inventario_sucursales', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_articulo');
            $table->uuid('id_sucursal');
            $table->uuid('id_almacen')->nullable();
            $table->float('precio1')->nullable();
            $table->float('precio2')->nullable();
            $table->float('precio3')->nullable();
            $table->float('precio4')->nullable();
            $table->float('precio5')->nullable();
            $table->float('precio6')->nullable();
            $table->float('precio7')->nullable();
            $table->float('precio8')->nullable();
            $table->float('precio9')->nullable();
            $table->float('precio10')->nullable();
            $table->integer('existencia')->nullable();
            $table->float('costo')->nullable();
            $table->float('minimo')->nullable();
            $table->float('maximo')->nullable();
            $table->integer('bloquedo_correcion')->default(0);
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
        Schema::dropIfExists('tbl_inventario_sucursales');
    }
}
