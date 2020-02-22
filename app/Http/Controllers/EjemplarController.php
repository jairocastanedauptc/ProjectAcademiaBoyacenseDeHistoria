<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use\App\Ejemplar;
use Illuminate\Support\Facades\DB;


class EjemplarController extends Controller
{

    public function listarPdf(){
        $ejemplares = Ejemplar::join('colecciones','ejemplares.idcoleccion','=','colecciones.id')
            ->join('categorias','ejemplares.idcategoria','=','categorias.id')
            ->select('categorias.nombre as nombre_categoria','colecciones.nombre as nombre_coleccion','ejemplares.id','ejemplares.titulo',
            'ejemplares.descripcion','ejemplares.editorial','ejemplares.cantidad','ejemplares.imagen',
            'ejemplares.elaborado','ejemplares.condicion','ejemplares.autor','ejemplares.fecha_publicacion')
            ->orderBy('ejemplares.titulo', 'desc')->get();

        $cont=Ejemplar::count();
        $pdf =\PDF::loadView('pdf.ejemplarespdf',['ejemplares'=>$ejemplares,'cont'=>$cont]);
        return $pdf->download('ejemplares.pdf');
    }
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $criterio = $request->criterio;
         
        if ($buscar==''){
            $ejemplares = Ejemplar::join('colecciones','ejemplares.idcoleccion','=','colecciones.id')
            ->join('categorias','ejemplares.idcategoria','=','categorias.id')
            ->select('categorias.nombre as nombre_categoria','colecciones.nombre as nombre_coleccion','ejemplares.id','ejemplares.titulo',
            'ejemplares.descripcion','ejemplares.idcategoria','ejemplares.idcoleccion','ejemplares.editorial','ejemplares.cantidad','ejemplares.imagen',
            'ejemplares.elaborado','ejemplares.condicion','ejemplares.autor','ejemplares.fecha_publicacion')
            ->orderBy('ejemplares.titulo', 'asc')->paginate(5);
        }
        else{
            $ejemplares = Ejemplar::join('categorias','ejemplares.idcategoria','=','categorias.id')
            ->join('colecciones','ejemplares.idcoleccion','=','colecciones.id')
            ->select('categorias.nombre as nombre_categoria','colecciones.nombre as nombre_coleccion','ejemplares.id','ejemplares.titulo',
            'ejemplares.descripcion','ejemplares.idcategoria','ejemplares.idcoleccion','ejemplares.editorial','ejemplares.cantidad','ejemplares.imagen',
            'ejemplares.elaborado','ejemplares.condicion','ejemplares.autor','ejemplares.fecha_publicacion')
            ->where('ejemplares.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('ejemplares.titulo', 'asc')->paginate(5);
        }
        return [
            'pagination' => [
                'total'        => $ejemplares->total(),
                'current_page' => $ejemplares->currentPage(),
                'per_page'     => $ejemplares->perPage(),
                'last_page'    => $ejemplares->lastPage(),
                'from'         => $ejemplares->firstItem(),
                'to'           => $ejemplares->lastItem(),
            ],
            'ejemplares' => $ejemplares
        ];
    }
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        
        $this->validate( $request,['fecha_publicacion' => 'required|regex:/\b[0-9]{4}/',]);
        $ejemplar = new Ejemplar();

        $ejemplar->idcategoria =$request->idcategoria;
        $ejemplar->idcoleccion =$request->idcoleccion;
        
        $ejemplar->titulo = $request->titulo;
        $ejemplar->descripcion= $request->descripcion;
        $ejemplar->condicion = '1';
        $ejemplar->elaborado= $request->elaborado;
        $ejemplar->fecha_publicacion= $request->fecha_publicacion;
        $ejemplar->cantidad=$request->cantidad;
        $ejemplar->autor= $request->autor;
        $ejemplar->editorial= $request->editorial;
  
              //inicio registrar imagen
              $exploded = explode(',',$request->imagen);
              $decoded = base64_decode($exploded[1]);
      
              if(str_contains($exploded[0],'jpeg')){
                  $extension = 'jpg';
              } 
              else{
      
                  $extension = 'png'; 
              }
              $fileName= $request->titulo.'.'.$extension;
              $path = public_path().'/img/ejemplar/'.$fileName;
              file_put_contents($path,$decoded);
              $ejemplar->imagen = $fileName;
              //fin registrar imagen
              $ejemplar->save();
    }
    public function update(Request $request)
     {
         if (!$request->ajax()) return redirect('/');
         $this->validate( $request,['fecha_publicacion' => 'required|regex:/\b[0-9]{4}/',]);
         $ejemplar = Ejemplar::findOrFail($request->id);
         $ejemplar->idcategoria =$request->idcategoria;
         $ejemplar->idcoleccion =$request->idcoleccion;
         $ejemplar->titulo = $request->titulo;
         $ejemplar->descripcion= $request->descripcion;
         $ejemplar->condicion = '1';
         $ejemplar->elaborado= $request->elaborado;
         $ejemplar->fecha_publicacion= $request->fecha_publicacion;
         $ejemplar->cantidad=$request->cantidad;
         $ejemplar->autor=$request->autor;
         
        $currentPhoto =$ejemplar->imagen;
        // imagen que se tiene hasta el momento

        //Editar imagen

        $currentPhoto = $ejemplar->imagen; 

        if($request->imagen != $currentPhoto){

            $exploded = explode(',',$request->imagen);
            $decoded = base64_decode($exploded[1]);
    
            if(str_contains($exploded[0],'jpeg')){
    
                $extension = 'jpg';
    
            } else{
    
                $extension = 'png'; 
            }
    
            $fileName= str_random().'.'.$extension;
            
            $path = public_path().'/img/ejemplar/'.$fileName;
    
            file_put_contents($path,$decoded);

            /*inicio eliminar del servidor*/
            $ejemplarImagen = public_path('/img/ejemplar/').$currentPhoto;
            if(file_exists($ejemplarImagen)){
                @unlink($ejemplarImagen);
            }

            /*fin eliminar del servidor*/
    
            $ejemplar->imagen = $fileName;

    }
    //fin editar imagen

    $ejemplar->save();
    }
    public function activar(Request $request){
        if (!$request->ajax()) return redirect('/');
        $ejemplar = Ejemplar::findOrFail($request->id);
        $ejemplar->condicion = '1';
        $ejemplar->save();
    }
    public function desactivar(Request $request){
        if (!$request->ajax()) return redirect('/');
        $ejemplar = Ejemplar::findOrFail($request->id);
        $ejemplar->condicion = '0';
        $ejemplar->save();
    }
    public function selectEjemplar(Request $request){
        if (!$request->ajax()) return redirect('/');
        $filtro= $request->filtro;
        $ejemplares = Ejemplar::where('condicion','=','1')
        ->where('ejemplares.titulo','like','%'.$filtro.'%')
        ->select('ejemplares.id','ejemplares.titulo')->orderBy('titulo', 'asc')->get();
        return ['ejemplares' => $ejemplares];
    }
 }
