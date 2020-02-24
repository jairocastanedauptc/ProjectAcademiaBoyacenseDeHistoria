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
        //$user->roles()->attach($rol_admin);

        /*DB::table('users')->truncate();
        DB::table('personas')->truncate();
        DB::table('roles')->insert(array('id'=>'1','nombre'=>'Administrador', 'descripcion'=>'Maneja el CRUD de categorías ,colecciones ,ejemplares y usuarios, además tiene acceso a la tabla de roles y reportes , puede generar informes y ver gráficos estadísticos'));
        DB::table('roles')->insert(array('id'=>'2','nombre'=>'Secretario'   , 'descripcion'=>'Maneja el CRUD de categorías ,colecciones y ejemplares, a su vez puede ver la tabla de roles y ver gráficos estadísticos'));
  
        DB::table('personas')->insert([
            'id'=>1,
            'nombres'=>'Jairo Alejandro',
            'apellidos' => 'Castañeda Pedraza',
            'celular'=>3219186301,
            'email'=>'jairo@gmail.com'

        ]);
        DB::table('users')->insert([
            'usuario'=>'admin',
            'password' => bcrypt('secret'),
        ]);*/
    }
}
