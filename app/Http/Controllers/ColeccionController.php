<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Coleccion;
use Illuminate\Support\Facades\DB;

class ColeccionController extends Controller
{
    public function normaliza ($cadena){
        $originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞ
        ßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
        $modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuy
         bsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
        $cadena = utf8_decode($cadena);
        $cadena = strtr($cadena, utf8_decode($originales), $modificadas);
        $cadena = strtolower($cadena);
        return utf8_encode($cadena);
    }
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
 
        $buscar = $request->buscar;
        $criterio = $request->criterio;
         
        if ($buscar==''){
            $colecciones = Coleccion::orderBy('id', 'desc')->paginate(10);
        }
        else{
            $colecciones = Coleccion::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(10);
        }
        return [
            'pagination' => [
                'total'        => $colecciones->total(),
                'current_page' => $colecciones->currentPage(),
                'per_page'     => $colecciones->perPage(),
                'last_page'    => $colecciones->lastPage(),
                'from'         => $colecciones->firstItem(),
                'to'           => $colecciones->lastItem(),
            ],
            'colecciones' => $colecciones
        ];
    }
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        
        $this->validate( $request,['nombre' => 'required|regex:/^[A-Z\s]+$/u',]);
        //$nombre = uft8_decode(normaliza($request->nombre));
        //$nombre= $nombre.normalize('NFD').replace(/[\u0300-\u036f]/g,"");
        //texto.normalize('NFD').replace(/[\u0300-\u036f]/g,"");
        //$nombre = strtoupper($request->nombre);
        $coleccion = new Coleccion();
        
        $coleccion->nombre = $request->nombre;
        $coleccion->descripcion= $request->descripcion;
        $coleccion->condicion = '1';
        $coleccion->save();
     }
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $this->validate( $request,['nombre' => 'required|regex:/^[A-Z\s]+$/u',]);
        $coleccion = Coleccion::findOrFail($request->id);
        $coleccion->nombre = $request->nombre;
        $coleccion->descripcion= $request->descripcion;
        $coleccion->condicion = '1';
        $coleccion->save();
    }
    public function activar(Request $request){
        if (!$request->ajax()) return redirect('/');
        $coleccion = Coleccion::findOrFail($request->id);
        $coleccion->condicion = '1';
        $coleccion->save();
    }
    public function desactivar(Request $request){
        if (!$request->ajax()) return redirect('/');
        $coleccion = Coleccion::findOrFail($request->id);
        $coleccion->condicion = '0';
        $coleccion->save();
    }
    public function selectColeccion(Request $request){
        if (!$request->ajax()) return redirect('/');
        $colecciones = Coleccion::where('condicion','=','1')
        ->select('id','nombre')->orderBy('nombre', 'asc')->get();
        return ['colecciones' => $colecciones];
    }
}
