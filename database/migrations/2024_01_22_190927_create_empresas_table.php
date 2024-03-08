<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Http\Traits\Uuids;

class CreateEmpresasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nombre')->nullable();
            $table->string('rfc')->nullable();
            $table->string('calle')->nullable();
            $table->string('cp')->nullable();
            $table->string('colonia')->nullable();
            $table->string('estado')->nullable();
            $table->string('localidad')->nullable();
            $table->string('municipio')->nullable();
            $table->string('numeroExterior')->nullable();
            $table->string('numeroInterior')->nullable();
            $table->string('certificado')->nullable();
            $table->string('archivokey')->nullable();
            $table->string('clave')->nullable();
            $table->string('serie')->nullable();
            $table->string('mail')->nullable();
            $table->string('llaveprivada')->nullable();
            $table->string('tipoFactura')->nullable();
            $table->integer('regimenfiscal')->nullable();
            $table->string('almacen')->nullable();
            $table->string('latitud')->nullable();
            $table->string('longitud')->nullable();
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
        Schema::dropIfExists('empresas');
    }
}
