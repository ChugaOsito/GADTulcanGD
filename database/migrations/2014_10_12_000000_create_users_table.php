<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('identification');
            $table->string('name');
            $table->string('lastname');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->smallInteger('rol')->default(2); //0 Administrador 1GestorCarpetas 2Funcionario
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();

            $table->unsignedBigInteger('departament_id');
            $table->foreign('departament_id')->references('id')->on('departaments');

            $table->unsignedBigInteger('treatment_id');
            $table->foreign('treatment_id')->references('id')->on('treatments');

            $table->unsignedBigInteger('position_id');
            $table->foreign('position_id')->references('id')->on('positions');

           
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
