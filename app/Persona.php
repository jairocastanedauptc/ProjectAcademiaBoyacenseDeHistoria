<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $fillable = ['nombres','apellidos','celular','email'];

    public function user(){
        return $this->hasOne('App\User');
    }
    public function registros(){
        return $this->hasMany('App\Registro');
    }
}
