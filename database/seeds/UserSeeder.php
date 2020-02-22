<?php

use Illuminate\Database\Seeder;
use Illuminate\Suppert\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();
        DB::table('users')->insert([
            
            'usuario'=>'admin',
            'password'=>''

        ]);
    }
}
