<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatRoleUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cat_role_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cat_role_id');
            $table->uuid('user_id');
            $table->timestamps();
            $table->foreign('cat_role_id')
                ->references('id')
                ->on('cat_roles')
                ->onDelete('cascade');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });

        $statement = "SELECT setval('cat_role_user_id_seq', 1, true);";

        DB::unprepared($statement);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_user');
    }
}
