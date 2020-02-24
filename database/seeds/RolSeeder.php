<?php

use Illuminate\Database\Seeder;

use App\Rol;

class RolSeeder extends Seeder
{
 
    public function run()
    {
        $rol = new Rol();
        $rol->id = 1;
        $rol->nombre = 'Administrator';
        $rol->descripcion='hace todo';
        $rol->save();

        $rol = new Rol();
        $rol->id = 2;
        $rol->nombre = 'Secretario';
        $rol->descripcion='no reportes ni usuarios';
        $rol->save();
    }
}
