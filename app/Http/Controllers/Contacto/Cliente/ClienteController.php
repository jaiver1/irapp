<?php

namespace App\Http\Controllers\Contacto\Cliente;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Contacto\Cliente;
use App\Models\Contacto\Persona;
use App\Models\Dato_basico\XUbicacion;
use App\Models\Dato_basico\XPais;
use App\Models\Dato_basico\XCiudad;
use App\Models\Root\User;
use Illuminate\Support\Facades\Validator;
use SweetAlert;

class ClienteController extends Controller
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
        Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR']);
        $clientes = Cliente::all();
        return View::make('contacto.clientes.index')->with(compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR']);
        $cliente = new Cliente;
        $persona = new Persona;
        $persona->ubicacion()->associate(new XUbicacion);
        $persona->ciudad()->associate(new XCiudad);
        $persona->usuario()->associate(new User);
        $cliente->persona()->associate($persona);
        $editar = false;
        $paises = XPais::orderBy('nombre', 'asc')->get();
        $usuarios = User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'ROLE_CLIENTE');
 })->whereNotIn('id',Persona::distinct()->select('usuario_id'))->get();
        return View::make('contacto.clientes.create')->with(compact('cliente','editar','paises','usuarios'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR']);

        $rules = array(
            'cedula'                   => 'required|max:50|unique:personas',
            'cuenta_banco'                   => 'max:50|unique:personas',
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
            'usuario_id'                   => 'required|unique:personas',
    );

        $validator = Validator::make($request->all(), $rules);


        if ($validator->fails()) {
            $request->flash();
            SweetAlert::error('Error','Errores en el formulario.');
            return Redirect::to('clientes/create')
                ->withErrors($validator);
        } else {
            $cliente = new Cliente;
            $persona = new Persona;
            $ubicacion = new XUbicacion;
            $ubicacion->latitud = $request->latitud;
            $ubicacion->longitud = $request->longitud;
            $ubicacion->save();
            $usuario = User::findOrFail($request->usuario_id);
            $ciudad = XCiudad::findOrFail($request->ciudad_id);

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
            $cliente->persona()->associate($persona);     
            $cliente->save();        

            SweetAlert::success('Exito','El cliente "'.$cliente->nombre.'" ha sido registrado.');
            return Redirect::to('clientes');
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
        Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR']);
        $cliente = Cliente::findOrFail($id);
        return View::make('contacto.clientes.show')->with(compact('cliente'));
        
        }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR']);
        $cliente = Cliente::findOrFail($id);
        $editar = true;
        $paises = XPais::orderBy('nombre', 'asc')->get();
        $usuarios = User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'ROLE_CLIENTE');
 })->whereNotIn('id',Persona::distinct()->select('usuario_id'))->get();
        return View::make('contacto.clientes.edit')->with(compact('cliente','editar','paises','usuarios'));
   
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id,Request $request)
    {
        Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR']);
        $rules = array(
            'cedula'                   => 'required|max:50|unique:personas',
            'cuenta_banco'                   => 'max:50|unique:personas',
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
            'usuario_id'                   => 'required|unique:personas',
    );

        $validator = Validator::make($request->all(), $rules);


        if ($validator->fails()) {
            $request->flash();
            SweetAlert::error('Error','Errores en el formulario.');
            return Redirect::to('clientes/create')
                ->withErrors($validator);
        } else {
            $cliente = Cliente::findOrFail($id);
            $cliente->ubicacion->latitud = $request->latitud;
            $cliente->ubicacion->longitud = $request->longitud;
            $usuario = User::findOrFail($request->usuario_id);
            $ciudad = XCiudad::findOrFail($request->ciudad_id);
            $cliente->persona->ciudad()->associate($ciudad);

            $cliente->persona->cedula = $request->cedula;
            $cliente->persona->cuenta_banco = $request->cuenta_banco;
            $cliente->persona->primer_nombre = $request->primer_nombre;
            $cliente->persona->segundo_nombre = $request->segundo_nombre;
            $cliente->cliente->persona->primer_apellido = $request->primer_apellido;
            $cliente->persona->segundo_apellido = $request->segundo_apellido;
            $cliente->persona->telefono_movil = $request->telefono_movil;
            $cliente->persona->telefono_fijo = $request->telefono_fijo;       
            $cliente->persona->barrio = $request->barrio;
            $cliente->persona->direccion = $request->direccion;    
            $cliente->save();        


        SweetAlert::success('Exito','El cliente "'.$cliente->nombre.'" ha sido editado.');
        return Redirect::to('clientes');
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
        Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR']);
        $cliente = Cliente::findOrFail($id);
    
        $cliente->delete();
        SweetAlert::success('Exito','El cliente "'.$cliente->nombre.'" ha sido eliminado.');
        return Redirect::to('clientes');
}
}