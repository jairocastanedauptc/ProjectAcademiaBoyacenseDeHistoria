<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coleccion extends Model
{
    protected $table = 'colecciones';
    protected $fillable = ['nombre','descripcion','condicion'];
    
    public function ejemplares(){
        return $this->hasMany('App\Ejemplar');
    }
}