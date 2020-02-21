<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ejemplar extends Model
{
    protected $table = 'ejemplares';
    protected $fillable = [
        'autor',
        'titulo',
        'descripcion',
        'elaborado',
        'editorial',
        'fecha_publicacion',
        'cantidad',
        'imagen',
        'condicion',
        'idcategoria',
        'idcoleccion'
    ];
    
    public function categoria(){
        return $this->belongsTo('App\Categoria');
    }
    public function coleccion(){
        return $this->belongsTo('App\Coleccion');
    }
    public function registros(){
        return $this->hasMany('App\Registro');
    }
    /*
    public function categoria(){
        return $this->belongsTo('App\Categoria');
    }
    public function coleccion(){
        return $this->belongsTo('App\Categoria');
    }
    */
    
  
    /*public function coleccion(){
        return $this->belongsTo('App\Coleccion');
    }
      public function categoria(){

        return $this->belongsTo('App\Categoria');
    }
    */
/*
/////////////////////////////////////////////////////////
    public function colecciones(){
        return $this->hasOne(Coleccion::class,'id','id_coleccion');
    }
    public function categorias(){
        return $this->hasOne(Categoria::class,'id','id_categoria');
    }
    */
    /*
    public function coleccion(){
        return $this->belongsTo(Coleccion::class,'id','id_coleccion');
    }
    public function categoria(){
        return $this->belongsTo(Categoria::class,'id','id_categoria');
    }
    //////////////////////////////////////////////////////////////
    */
}
