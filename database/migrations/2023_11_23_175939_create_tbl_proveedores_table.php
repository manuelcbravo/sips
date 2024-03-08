<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblProveedoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_proveedores', function (Blueprint $table) {
            //general
            $table->uuid('id')->primary();
            $table->string('proveedor')->nullable();
            $table->string('nombre')->nullable();
            $table->string('apellido_paterno')->nullable();
            $table->string('apellido_materno')->nullable();
            $table->string('rfc')->nullable();
            $table->integer('id_regimen_fiscal')->nullable();
            $table->integer('id_cliente_tipo')->nullable();
            $table->integer('id_estatus')->default(1);
            $table->integer('externo')->default(0);
            $table->date('fecha_nacimiento')->nullable();

            //direccion
            $table->integer('id_estado')->nullable();
            $table->string('otro_estado')->nullable();
            $table->integer('id_municipio')->nullable();
            $table->string('otro_municipio')->nullable();
            $table->integer('id_colonia')->nullable();
            $table->string('colonia')->nullable();
            $table->string('calle')->nullable();
            $table->string('interior')->nullable();
            $table->string('exterior')->nullable();
            $table->string('cp')->nullable();

            //contacto
            $table->string('celular')->nullable();
            $table->string('oficina')->nullable();
            $table->string('casa')->nullable();
            $table->string('email')->nullable();
            $table->string('correo2')->nullable();

            //datos tabla
            $table->double('credito', 8, 2)->nullable();
            $table->integer('dias')->default(0);
            $table->integer('precio')->default(1);
            $table->double('saldo', 8, 2)->nullable();
            //fin

            //datos extra
            $table->string('imagen_perfil')->nullable();
            $table->uuid('id_usuario_reg')->nullable();
            $table->text('comentario_registro')->nullable();
            $table->text('comentario')->nullable();
            $table->integer('genero')->nullable()->comment('1 para hombre, 2 para mujer');
            // fin

            //datos representante legal
            $table->string('rl_nombre')->nullable();
            $table->string('rl_apellido_paterno')->nullable();
            $table->string('rl_apellido_materno')->nullable();
            $table->string('rl_email')->nullable();
            $table->string('rl_rfc')->nullable();
            $table->string('rl_celular')->nullable();
            $table->string('rl_oficina')->nullable();
            $table->string('rl_casa')->nullable();

            $table->string('cuenta_principal')->nullable();
            $table->string('cuenta_secundaria')->nullable();


            //datos conexión inicio
            $table->timestamp('ultimo_contacto')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('password_plain')->nullable();
            $table->integer('activado')->default(0);
            $table->integer('aval_activos')->default(0);
            $table->integer('creditos')->default(0);
            $table->integer('trabajos')->default(0);
            $table->string('token_activation', 80)->unique()->nullable()->default(null);
            $table->integer('status_app')->default(0);
            $table->rememberToken();
            // fin

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
        Schema::dropIfExists('tbl_proveedores');
    }
}
