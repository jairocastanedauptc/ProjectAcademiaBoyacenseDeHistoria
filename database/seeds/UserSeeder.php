<?php

use Illuminate\Database\Seeder;

use App\User;
use App\Persona;
use App\Rol;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rol_admin= Rol::where('nombre','Administrador')->first();
        $persona=Persona::where('nombres','Jairo Alejandro')->first();

        $user = new User();
        $user->usuario='admin';
        $user->id=1;
        $user->condicion=1;
        $user->password = bcrypt('admin');
        $user->idrol=1;
        $user->save();
    }
}
