<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coleccion extends Model
{
    protected $table = 'colecciones';
    public $timestamps = false;
    protected $fillable = ['nombre','descripcion','condicion'];
}
