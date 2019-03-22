<?php

namespace App\Http\Controllers\Contacto\Colaborador;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Contacto\Colaborador;
use App\Models\Contacto\Persona;
use App\Models\Dato_basico\Ubicacion;
use App\Models\Dato_basico\Pais;
use App\Models\Dato_basico\Ciudad;
use App\Models\Root\User;
use App\Models\Root\Role;
use App\Models\Actividad\Servicio;
use Illuminate\Support\Facades\Validator;
use SweetAlert;

class ColaboradorController extends Controller
{
    protected $redirectTo = '/login';
    
    public function __construct()
    {
     $this->middleware('auth');
    }
 /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR'],TRUE);
        $colaboradores = Colaborador::all();
        return View::make('contacto.colaboradores.index')->with(compact('colaboradores'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR'],TRUE);
        $colaborador = new Colaborador;
        $persona = new Persona;
        $persona->ubicacion()->associate(new Ubicacion);
        $persona->ciudad()->associate(new Ciudad);
        $persona->usuario()->associate(new User);
        $colaborador->persona()->associate($persona);
        $editar = false;
        $paises = Pais::orderBy('nombre', 'asc')->get();
        /*$usuarios = User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'ROLE_CLIENTE');
 })->whereNotIn('id',Persona::distinct()->select('usuario_id'))->get();
        return View::make('contacto.colaboradores.create')->with(compact('colaborador','editar','paises','usuarios'));*/
        return View::make('contacto.colaboradores.create')->with(compact('colaborador','editar','paises'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR'],TRUE);

        $rules = array(
            'cedula'                   => 'required|max:50|unique:personas',
            'cuenta_banco'                   => 'max:50',
            'primer_nombre'                   => 'required|max:50',
            'segundo_nombre'                   => 'max:50',
            'primer_apellido'                   => 'required|max:50',
            'segundo_apellido'                   => 'required|max:50',
            'telefono_fijo'                   => 'max:50',
            'telefono_movil'                   => 'required|max:50',
            'barrio'                   => 'required|max:50',
            'direccion'                   => 'required|max:50',
            'latitud'                   => 'required|max:50',
            'longitud'                   => 'required|max:50',
            'ciudad_id'              => 'required',
            'name'                  => 'required|max:50|unique:users',
                'email'                 => 'required|email|max:100|unique:users',
                'password'              => 'required|between:8,50|confirmed',
                'password_confirmation' => 'required|same:password',
                // 'usuario_id'                   => 'required|unique:personas',
    );

        $validator = Validator::make($request->all(), $rules);


        if ($validator->fails()) {
            $request->flash();
            SweetAlert::error('Error','Errores en el formulario.');
            return Redirect::to('colaboradores/create')
                ->withErrors($validator);
        } else {

            $role = Role::findOrFail(3);
            $usuario = new User;
            $usuario->name = $request->name;
            $usuario->email = $request->email;
            $usuario->password =  bcrypt($request->password);         
            $usuario->save();
            $usuario->roles()->attach($role);

            $colaborador = new Colaborador;
            $persona = new Persona;
            $ubicacion = new Ubicacion;
            $ubicacion->latitud = $request->latitud;
            $ubicacion->longitud = $request->longitud;
            $ubicacion->save();
            $usuario = User::findOrFail($usuario->id);
            $ciudad = Ciudad::findOrFail($request->ciudad_id);

            $persona->cedula = $request->cedula;
            $persona->cuenta_banco = $request->cuenta_banco;
            $persona->primer_nombre = $request->primer_nombre;
            $persona->segundo_nombre = $request->segundo_nombre;
            $persona->primer_apellido = $request->primer_apellido;
            $persona->segundo_apellido = $request->segundo_apellido;
            $persona->telefono_movil = $request->telefono_movil;
            $persona->telefono_fijo = $request->telefono_fijo;       
            $persona->barrio = $request->barrio;
            $persona->direccion = $request->direccion;

            $persona->usuario()->associate($usuario);
            $persona->ciudad()->associate($ciudad);
            $persona->ubicacion()->associate($ubicacion);
            $persona->save();
            $colaborador->persona()->associate($persona);     
            $colaborador->save();        

            SweetAlert::success('Exito','El colaborador "'.$colaborador->nombre.'" ha sido registrado.');
            return Redirect::to('colaboradores');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {  
        Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR'],TRUE);
        $colaborador = Colaborador::findOrFail($id);
        return View::make('contacto.colaboradores.show')->with(compact('colaborador'));
        
        }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR'],TRUE);
        $colaborador = Colaborador::findOrFail($id);
        $editar = true;
        $paises = Pais::orderBy('nombre', 'asc')->get();
        /*$usuarios = User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'ROLE_CLIENTE');
 })->whereNotIn('id',Persona::distinct()->select('usuario_id'))->get();
        return View::make('contacto.colaboradores.edit')->with(compact('colaborador','editar','paises','usuarios'));*/
           return View::make('contacto.colaboradores.edit')->with(compact('colaborador','editar','paises'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id,Request $request)
    {
        Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR'],TRUE);
        $rules = array(
            'cedula'                   => 'required|max:50|unique:personas',
            'cuenta_banco'                   => 'max:50',
            'primer_nombre'                   => 'required|max:50',
            'segundo_nombre'                   => 'max:50',
            'primer_apellido'                   => 'required|max:50',
            'segundo_apellido'                   => 'required|max:50',
            'telefono_fijo'                   => 'max:50',
            'telefono_movil'                   => 'required|max:50',
            'barrio'                   => 'required|max:50',
            'direccion'                   => 'required|max:50',
            'latitud'                   => 'required|max:50',
            'longitud'                   => 'required|max:50',
            'ciudad_id'              => 'required',
           // 'usuario_id'                   => 'required|unique:personas',
    );

        $validator = Validator::make($request->all(), $rules);


        if ($validator->fails()) {
            $request->flash();
            SweetAlert::error('Error','Errores en el formulario.');
            return Redirect::to('colaboradores/create')
                ->withErrors($validator);
        } else {
            $colaborador = Colaborador::findOrFail($id);
            $colaborador->ubicacion->latitud = $request->latitud;
            $colaborador->ubicacion->longitud = $request->longitud;
            $usuario = User::findOrFail($request->usuario_id);
            $ciudad = Ciudad::findOrFail($request->ciudad_id);
            $colaborador->persona->ciudad()->associate($ciudad);

            $colaborador->persona->cedula = $request->cedula;
            $colaborador->persona->cuenta_banco = $request->cuenta_banco;
            $colaborador->persona->primer_nombre = $request->primer_nombre;
            $colaborador->persona->segundo_nombre = $request->segundo_nombre;
            $colaborador->colaborador->persona->primer_apellido = $request->primer_apellido;
            $colaborador->persona->segundo_apellido = $request->segundo_apellido;
            $colaborador->persona->telefono_movil = $request->telefono_movil;
            $colaborador->persona->telefono_fijo = $request->telefono_fijo;       
            $colaborador->persona->barrio = $request->barrio;
            $colaborador->persona->direccion = $request->direccion;    
            $colaborador->save();        


        SweetAlert::success('Exito','El colaborador "'.$colaborador->nombre.'" ha sido editado.');
        return Redirect::to('colaboradores');
    }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR'],TRUE);
        $colaborador = Colaborador::findOrFail($id);
    
        $colaborador->delete();
        SweetAlert::success('Exito','El colaborador "'.$colaborador->nombre.'" ha sido eliminado.');
        return Redirect::to('colaboradores');
}

  /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function get_servicios($id,$isSearching)
    {  
        Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR'],TRUE);
        if($isSearching){
            $servicios = Servicio::whereNotIn('id', function($query) use ($id){
                $query->select('servicio_id')->from('colaborador_servicio')
                ->where('colaborador_id','=',$id)->distinct();
            })->get();
            $detalle_orden = false;
            $prefix = "";
        return View::make('include.actividad.servicios.modal_search')->with(compact('servicios','detalle_orden','prefix'));
        }else{
            $colaborador = Colaborador::findOrFail($id);
        return View::make('include.actividad.servicios.datatable')->with(compact('colaborador'));
        }

        }

        
        public function add_servicios(Request $request)
        {  
            Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR'],TRUE);
            try{
                $rules = array(
                    'servicio'                   => 'numeric|required',
                    'colaborador'                   => 'numeric|required'          
                  );
    
            $validator = Validator::make($request->all(), $rules);
    
    
            if ($validator->fails()) {
                return response()->json(['status'=>500,'message'=>$validator]);
            }else{
                $colaborador = Colaborador::findOrFail($request->servicio);
                $servicio = Servicio::findOrFail($request->servicio);
                $colaborador->servicios()->attach($servicio);
                return response()->json(['status'=>200,'message'=>'OK']);
               
        }

        } catch (Throwable $e) {
            return response()->json(['status'=>500,'message'=>$e->getMessage()]);
        } 
            }

            public function delete_servicios(Request $request)
            {  
                Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR'],TRUE);
                try{
                    $rules = array(
                        'servicio'                   => 'numeric|required',
                        'colaborador'                   => 'numeric|required'          
                      );
        
                $validator = Validator::make($request->all(), $rules);
        
        
                if ($validator->fails()) {
                    return response()->json(['status'=>500,'message'=>$validator]);
                }else{
                    $colaborador = Colaborador::findOrFail($request->servicio);
                    $servicio = Servicio::findOrFail($request->servicio);
                    $colaborador->servicios()->detach($servicio);
                    return response()->json(['status'=>200,'message'=>'OK']);
                   
            }
    
            } catch (Throwable $e) {
                return response()->json(['status'=>500,'message'=>$e->getMessage()]);
            } 
                }

}