<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        DB::table('')->insert([
            
            'usuario'=>'admin',
            'password'=>''

        ]);
        $this->call(Users::class);

    }
}
