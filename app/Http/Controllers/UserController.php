<?php
 
namespace App\Http\Controllers;
use App\User;
use App\Persona;
use Illuminate\Support\Facades\DB;
//use Illuminate\Support\Facades\Validator; 
use Illuminate\Http\Request;
 
class UserController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
 
        $buscar = $request->buscar;
        $criterio = $request->criterio;
         
        if ($buscar==''){
            $personas = User::join('personas','users.id','=','personas.id')
            ->join('roles','users.idrol','=','roles.id')
            ->select('personas.id','personas.nombres','personas.celular',
            'personas.apellidos','personas.email','users.usuario','users.password',
            'users.condicion','users.idrol','roles.nombre as rol')
            ->orderBy('personas.id', 'desc')->paginate(8);
        }
        else{
            $personas = User::join('personas','users.id','=','personas.id')
            ->join('roles','users.idrol','=','roles.id')
            ->select('personas.id','personas.nombres','personas.celular',
            'personas.apellidos','personas.email','users.usuario','users.password',
            'users.condicion','users.idrol','roles.nombre as rol')           
            ->where('personas.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('personas.id', 'desc')->paginate(8);
        } 
        return [
            'pagination' => [
                'total'        => $personas->total(),
                'current_page' => $personas->currentPage(),
                'per_page'     => $personas->perPage(),
                'last_page'    => $personas->lastPage(),
                'from'         => $personas->firstItem(),
                'to'           => $personas->lastItem(),
            ],
            'personas' => $personas
        ];
    }

    public function store(Request $request)
    {
           // $this->validate( $request,['apellidos' => 'required|regex:/^[A-Z\s]+$/u',]);
            //$this->validate( $request,['celular' => 'required|regex:/([0-9]){10}',]);  
            //$this->validate( $request,['email' => 'required|email',]);
            //$this->validate( $request,['usuario' => 'required||regex:/^[a-zA-Z\s]+$/u',]); 
            //numeric|between:9,11
            //'required|regex:/^[\pL\s\-]+$/u'
        if (!$request->ajax()) return redirect('/');    
            //$this->validate( $request,['nombres' => 'required|regex:/^[A-Z\s]+$/u',
            //'apellidos' => 'required|regex:/^[A-Z\s]+$/u',
            //'celular' => 'required|regex:/([0-9]){10}',
            //'email' => 'required|email',
            //'usuario' => 'required||regex:/^[a-zA-Z\s]+$/u'
            //]); 

            $fields =$request->validate([
                'nombres'=>'regex:/^[A-Z\s]+$/u',
                'apellidos'=> 'regex:/^[A-Z\s]+$/u',
                'email'=>['required','email'],
                'usuario'=>['required','string','unique:users,usuario'],
                'password'=>['required','min:8','max:50'],
                'celular'=>['required','digits:10','integer']
            ]
            /*[
                'nombres.required'=>'Los nombres son obligatorios',
                'apellidos.required'=>'los apellidos son obligatorios',
                'email.required'=>'el correo es obligatorio',
                'usuario.required'=>'el usuario es oblogatorio',
                'password.required'=>'la contraseñaes obligatoria',
                'celular.required'=>'el celular es obligatorio'
            ]
            */
        );
            //numeric|between:9,11
                    //try{
                        DB::beginTransaction();
                                   
                        $persona = new Persona();
                        $persona->nombres = $request->nombres;
                        $persona->celular = $request->celular;
                        $persona->apellidos = $request->apellidos;
                        $persona->email = $request->email;     
                        $persona->save();
            
                        $user = new User();
                        $user->usuario = $request->usuario;
                        $user->password = bcrypt( $request->password);
                        $user->condicion = '1';
                        $user->idrol = $request->idrol;          
            
                        $user->id = $persona->id;
                        $user->save();
    
                        DB::commit();
            
                   // } catch (Exception $e){
                     //   DB::rollBack();
                    //}              
    }
 
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $fields =$request->validate([
            'nombres'=>'regex:/[A-Za-z]/',
            'apellidos'=> 'regex:/[A-Za-z]/',
            'email'=>['required','email'],
            'usuario'=>['required','string','unique:users,usuario'],
            'password'=>['required','min:8','max:50'],
            'celular'=>['required','digits:10']
        ]);
         
        //try{
            DB::beginTransaction();
 
            //Buscar primero el proveedor a modificar
            $user = User::findOrFail($request->id);
 
            $persona = Persona::findOrFail($user->id);
 
            $persona->nombres = $request->nombres;
            $persona->apellidos = $request->apellidos;
            $persona->celular = $request->celular;
            $persona->email = $request->email;
            $persona->save();
             
            $user->usuario = $request->usuario;
            $user->password = bcrypt( $request->password);
            $user->condicion = '1';
            $user->idrol = $request->idrol;
            $user->save();
 
            DB::commit();
 
        /*} catch (Exception $e){
            DB::rollBack();
        }*/
    }
 
    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $user = User::findOrFail($request->id);
        $user->condicion = '0';
        $user->save();
    }
 
    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $user = User::findOrFail($request->id);
        $user->condicion = '1';
        $user->save();
    }
    public function selectPersona(Request $request){
        if (!$request->ajax()) return redirect('/');
        $personas = Persona::select('id','nombres')->orderBy('nombres', 'asc')->get();
        return ['personas' => $personas];
    }
 
}