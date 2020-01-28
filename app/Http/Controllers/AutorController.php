<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Autor;
use Illuminate\Support\Facades\DB;

class AutorController extends Controller
{
      
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
 
        $buscar = $request->buscar;
        $criterio = $request->criterio;
         
        if ($buscar==''){
            $autores = Autor::orderBy('id', 'desc')->paginate(3);
        }
        else{
            $autores = Autor::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(3);
        }
        return [
            'pagination' => [
                'total'        => $autores->total(),
                'current_page' => $autores->currentPage(),
                'per_page'     => $autores->perPage(),
                'last_page'    => $autores->lastPage(),
                'from'         => $autores->firstItem(),
                'to'           => $autores->lastItem(),
            ],
            'autores' => $autores
        ];
    }
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $autor = new Autor();
        $autor->nombre = $request->nombre;
        $autor->condicion = '1';
        $autor->save();
        
       // if (!$request->ajax()) return redirect('/');
        $categoria = new Categoria();
        $categoria->nombre = $request->nombre;
        $categoria->descripcion= $request->descripcion;
        $categoria->condicion = '1';
        $categoria->save();
     }
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $autor = Autor::findOrFail($request->id);
        $autor->nombre = $request->nombre;
        $autor->condicion = '1';
        $autor->save();
    }
    public function activar(Request $request){
        if (!$request->ajax()) return redirect('/');
        $autor = Autor::findOrFail($request->id);
        $autor->condicion = '1';
        $autor->save();
    }
    public function desactivar(Request $request){
        if (!$request->ajax()) return redirect('/');
        $autor = Autor::findOrFail($request->id);
        $autor->condicion = '0';
        $autor->save();
    }
}