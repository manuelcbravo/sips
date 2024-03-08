<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Http\Traits\Uuids;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('apellidos');
            $table->integer('activado')->default(1);
            $table->integer('visto')->default(1);
            $table->integer('rol')->default(0);
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('password_plain');
            $table->string('api_token', 80)->after('password')->unique()->nullable()->default(null);
            $table->string('imagen_perfil')->nullable()->default(null);
            $table->string('telefono')->nullable();
            $table->string('telefono_oficina')->nullable();
            $table->string('celular')->nullable();
            $table->string('celular2')->nullable();
            $table->string('titulo')->default('Dr.');
            $table->string('titulo_presenta')->nullable();
            $table->string('direccion_principal')->nullable();
            $table->uuid('id_sucursal')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
