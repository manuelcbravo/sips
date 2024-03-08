<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatLineasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cat_lineas', function (Blueprint $table) {
            $table->id();
            $table->string('linea')->nullable();
            $table->string('nombre')->nullable();
            $table->softDeletes();            
            $table->timestamps();
        });

        DB::statement('ALTER SEQUENCE cat_lineas_id_seq RESTART WITH 17'); // Puedes ajustar este valor según tus necesidades

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cat_lineas');
    }
}
