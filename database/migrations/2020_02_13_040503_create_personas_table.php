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
            $table->string('email', 60)->nullable();
            $table->timestamps();
        });
        DB::table('personas')->insert(array('id'=>'1','nombres'=>'Jairo Alejandro', 'apellidos'=>'Castaneda Pedraza','celular'=>'3219578963','email'=>'jairo.castaneda@uptc.edu.co'));
    }
    public function down()
    {
        Schema::dropIfExists('personas');
    }
}
