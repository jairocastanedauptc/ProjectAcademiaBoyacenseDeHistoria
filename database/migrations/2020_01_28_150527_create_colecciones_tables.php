<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateColeccionesTables extends Migration
{
    public function up()
    {
        Schema::create('colecciones', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre',45);
            $table->string('descripcion',256);
            $table->boolean('condicion')->default(1);
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('colecciones');
    }
}
