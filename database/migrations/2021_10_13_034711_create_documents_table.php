<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('number');
            $table->boolean('read')->default(0);
            $table->string('path');
            $table->boolean('public')->default(0);
            $table->unsignedBigInteger('folder_id')->default(1);
            $table->foreign('folder_id')->references('id')->on('folders');
            $table->unsignedBigInteger('type_id');
            $table->foreign('type_id')->references('id')->on('types');
   
            //La siguiente se usara para realizar pruebas de envio de documentos posteriormente
/*
            $table->integer('receiver_id')->unsigned();
            $table->foreign('receiver_id')->references('id')->on('users');
*/
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
        Schema::dropIfExists('documents');
    }
}
