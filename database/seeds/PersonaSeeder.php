<?php

use Illuminate\Database\Seeder;

use App\Persona;
class PersonaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $persona = new Persona();
        $persona->id = 1;
        $persona->nombres = 'Jairo Alejandro';
        $persona->apellidos='Castañeda Pedraza';
        $persona->celular='3219186301';
        $persona->email='jairo@gmail.com';
        $persona->save();
    }
}
