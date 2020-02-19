<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Registro extends Model
{
    protected $table = 'registros';
    protected $fillable = [
        'tema',
        'idejemplar',
        'idpersona'
    ];
    public function persona(){
        return $this->belongsTo('App\Persona');
    }
    public function ejemplar(){
        return $this->belongsTo('App\Ejemplar');
    }
}
