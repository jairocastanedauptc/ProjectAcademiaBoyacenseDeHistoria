<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categoria;
use Illuminate\Support\Facades\DB;

class CategoriaController extends Controller
{ 
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
 
        $buscar = $request->buscar;
        $criterio = $request->criterio;
         
        if ($buscar==''){
            $categorias = Categoria::orderBy('id', 'desc')->paginate(10);
        }
        else{
            $categorias = Categoria::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(10);
        }
        return [
            'pagination' => [
                'total'        => $categorias->total(),
                'current_page' => $categorias->currentPage(),
                'per_page'     => $categorias->perPage(),
                'last_page'    => $categorias->lastPage(),
                'from'         => $categorias->firstItem(),
                'to'           => $categorias->lastItem(),
            ],
            'categorias' => $categorias
        ];
    }
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        //$this->validate( $request,['nombre' => 'required|regex:/[A-Za-z]/',]);
        $this->validate( $request,['nombre' => 'required|regex:/^[A-Z\s]+$/u',]);
        $categoria = new Categoria();
        $categoria->nombre = $request->nombre;
        $categoria->descripcion= $request->descripcion;
        $categoria->condicion = '1';
        $categoria->save();
     }
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $this->validate( $request,['nombre' => 'required|regex:/^[A-Z\s]+$/u',]);
        $categoria = Categoria::findOrFail($request->id);
        $categoria->nombre = $request->nombre;
        $categoria->descripcion= $request->descripcion;
        $categoria->condicion = '1';
        $categoria->save();
    }
    
    public function activar(Request $request){
        if (!$request->ajax()) return redirect('/');
        $categoria = Categoria::findOrFail($request->id);
        $categoria->condicion = '1';
        $categoria->save();
    }
    public function desactivar(Request $request){
        if (!$request->ajax()) return redirect('/');
        $categoria = Categoria::findOrFail($request->id);
        $categoria->condicion = '0';
        $categoria->save();
    }
    public function selectCategoria(Request $request){
        if (!$request->ajax()) return redirect('/');
        $categorias = Categoria::where('condicion','=','1')
        ->select('id','nombre')->orderBy('nombre', 'asc')->get();
        return ['categorias' => $categorias];
    }
}
