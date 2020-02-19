<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEjemplaresTable extends Migration
{
    public function up()
    {
        Schema::create('ejemplares', function (Blueprint $table) {
            $table->increments('id');            
            $table->string('titulo');
            $table->string('descripcion');
            $table->boolean('elaborado')->default(0);
            $table->string('editorial')->nullable();
            $table->string('fecha_publicacion')->nullable();;
            
            $table->string('cantidad');
            $table->string('imagen',300)->nullable();
            $table->boolean('condicion')->default(1);
            $table->string('autor',300);
           
            $table->integer('idcategoria')->unsigned();
            $table->foreign('idcategoria')->references('id')->on('categorias');

            $table->integer('idcoleccion')->unsigned();
            $table->foreign('idcoleccion')->references('id')->on('colecciones');
            
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('ejemplares');
    }
}
