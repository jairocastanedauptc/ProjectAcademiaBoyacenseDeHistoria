<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Coleccion;
class ColeccionController extends Controller
{
    
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
        $coleccion = new Coleccion();
        $coleccion->nombre = $request->nombre;
        $coleccion->descripcion= $request->descripcion;
        $coleccion->condicion = '1';
        $coleccion->save();
     }
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
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
