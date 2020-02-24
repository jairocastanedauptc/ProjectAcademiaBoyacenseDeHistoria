<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 30)->unique();
            $table->string('descripcion', 200)->nullable();
            $table->boolean('condicion')->default(1);          
        });
        //DB::table('roles')->insert(array('id'=>'1','nombre'=>'Administrador', 'descripcion'=>'Maneja el CRUD de categorías ,colecciones ,ejemplares y usuarios, además tiene acceso a la tabla de roles y reportes , puede generar informes y ver gráficos estadísticos'));
        //DB::table('roles')->insert(array('id'=>'2','nombre'=>'Secretario'   , 'descripcion'=>'Maneja el CRUD de categorías ,colecciones y ejemplares, a su vez puede ver la tabla de roles y ver gráficos estadísticos'));
    }
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
