<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAutoresTable extends Migration
{

    public function up()
    {
        Schema::create('autores', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre',45);
            $table->boolean('condicion')->default(1);
        });
    }

    public function down()
    {
        Schema::dropIfExists('autores');
    }
}
