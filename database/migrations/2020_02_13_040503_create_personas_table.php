<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonasTable extends Migration
{
    public function up()
    {
        Schema::create('personas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombres', 100);
            $table->string('apellidos', 70)->nullable();
            $table->string('celular',10)->nullable();
            $table->string('email', 20)->nullable();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('personas');
    }
}
