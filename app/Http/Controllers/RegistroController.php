<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Registro;
use App\Persona;
use Illuminate\Support\Facades\DB;

class RegistroController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $criterio = $request->criterio;
         
        if ($buscar==''){
            $registros = Registro::join('ejemplares','registros.idejemplar','=','ejemplares.id')
            ->join('personas','registros.idpersona','=','personas.id')
            ->select('personas.nombres as nombre_persona','personas.id as idpersona','ejemplares.titulo as nombre_ejemplar','ejemplares.id','registros.tema',
            'registros.updated_at','personas.celular','registros.id')
            ->orderBy('registros.id', 'desc')->paginate(10);
        }
        else{
            $registros = Registro::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(10);
        }
        return [
            'pagination' => [
                'total'        => $registros->total(),
                'current_page' => $registros->currentPage(),
                'per_page'     => $registros->perPage(),
                'last_page'    => $registros->lastPage(),
                'from'         => $registros->firstItem(),
                'to'           => $registros->lastItem(),
            ],
            'registros' => $registros
        ];
    }
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        try{
            DB::beginTransaction();
            $persona = new Persona();
            $persona->nombres = $request->nombre_persona;
            $persona->celular = $request->celular;       
            $persona->save();

            $registro = new Registro();
            $registro->tema  = $request->tema;
            $registro->idejemplar =$request->idejemplar;
            $registro->idpersona =$persona->id;
            $registro->save();
 
            DB::commit();
 
        } catch (Exception $e){
            DB::rollBack();
        }
     }
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $registro = Registro::findOrFail($request->id);
        $registro->tema  = $request->tema;
        $registro->idejemplar =$request->idejemplar;
        $registro->idpersona =$request->idpersona;
        $registro->save();

        $persona = Persona::findOrFail($request->idpersona);
        $persona->nombres = $request->nombre_persona;
        $persona->celular =$request->celular;
        $persona->save(); 
    }
    
    public function activar(Request $request){
        if (!$request->ajax()) return redirect('/');
        $registro = Registro::findOrFail($request->id);
        $registro->condicion = '1';
        $registro->save();
    }
    public function desactivar(Request $request){
        if (!$request->ajax()) return redirect('/');
        $registro = Registro::findOrFail($request->id);
        $registro->condicion = '0';
        $registro->save();
    }
    public function selectCategoria(Request $request){
        if (!$request->ajax()) return redirect('/');
        $categorias = Categoria::where('condicion','=','1')
        ->select('id','nombre')->orderBy('nombre', 'asc')->get();
        return ['categorias' => $categorias];
    }
}
