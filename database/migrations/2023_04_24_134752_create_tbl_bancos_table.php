<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Http\Traits\Uuids;

class CreateTblBancosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_bancos', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('cuenta');
            $table->string('clve_interbancaria')->nullable();
            $table->string('clve_swift')->nullable();
            $table->string('nombre_titular');
            $table->string('institucion');
            $table->string('no_tarjeta')->nullable();
            $table->string('moneda')->nullable();
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
        Schema::dropIfExists('tbl_bancos');
    }
}
