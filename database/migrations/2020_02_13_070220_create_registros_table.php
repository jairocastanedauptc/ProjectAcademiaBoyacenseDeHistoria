<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegistrosTable extends Migration
{
    public function up()
    {
        Schema::create('registros', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('idpersona')->unsigned();
            $table->foreign('idpersona')->references('id')->on('personas')->onDelete('cascade');

            $table->integer('idejemplar')->unsigned();
            $table->foreign('idejemplar')->references('id')->on('ejemplares')->onDelete('cascade');
             
            $table->string('tema');
 
            $table->rememberToken();
            $table->timestamps();
        });
    }   
    public function down()
    {
        Schema::dropIfExists('registros');
    }
}
