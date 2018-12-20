<?php

namespace App\Http\Controllers\Actividad\Orden;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Actividad\Orden;
use App\Models\Dato_basico\XUbicacion;
use App\Models\Dato_basico\XPais;
use App\Models\Dato_basico\XCiudad;
use App\Models\Root\User;
use App\Models\Contacto\Cliente;
use App\Models\Contacto\Persona;
use Illuminate\Support\Facades\Validator;
Use SweetAlert;
Use DB;

class OrdenController extends Controller
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
        $ordenes = Orden::all();
        return View::make('actividad.ordenes.index')->with(compact('ordenes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR']);
        $orden = new Orden();
        $orden->ciudad()->associate(new XCiudad);
        $orden->ubicacion()->associate(new XUbicacion);
        $orden->cliente()->associate(new Cliente);
        $estados = Orden::getEstados();
        $editar = false;
        $paises = XPais::orderBy('nombre', 'asc')->get();
        $clientes = DB::table('clientes')
        ->join('personas', 'clientes.persona_id', '=', 'personas.id')
        ->select('clientes.id', 'personas.primer_nombre', 'personas.segundo_nombre', 'personas.primer_apellido', 'personas.segundo_apellido')
        ->whereIn('clientes.persona_id',Persona::distinct()->select('id')->whereIn('usuario_id',User::distinct()->select('id')->whereHas('roles', function ($query) {
            $query->where('name', '=', 'ROLE_CLIENTE');
})))->get();

       return View::make('actividad.ordenes.create')->with(compact('orden','editar','paises','clientes','estados'));
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
                'nombre'                   => 'required|max:50',
                'barrio'                   => 'required|max:50',
            'direccion'                   => 'required|max:50',
            'latitud'                   => 'required|max:50',
            'longitud'                   => 'required|max:50',
            'ciudad_id'              => 'required',
            'cliente_id'                   => 'required',
            'fecha_inicio'                   => 'required|date'
        );

        $validator = Validator::make($request->all(), $rules);


        if ($validator->fails()) {
            SweetAlert::error('Error','Errores en el formulario.');
            return Redirect::to('ordenes/create')
                ->withErrors($validator);
        } else {
            $orden = new Orden;
            $ubicacion = new XUbicacion;
            $cliente = Cliente::findOrFail($request->cliente_id);
            $ciudad = XCiudad::findOrFail($request->ciudad_id);
            $ubicacion->latitud = $request->latitud;
            $ubicacion->longitud = $request->longitud;
            $ubicacion->save();        
            $orden->nombre = $request->nombre; 
            $orden->estado = "Abierta";
            $orden->barrio = $request->barrio;
            $orden->direccion = $request->direccion;   
            $orden->fecha_inicio = $request->fecha_inicio;
            $orden->ciudad()->associate($ciudad);
            $orden->cliente()->associate($cliente);
            $orden->ubicacion()->associate($ubicacion);
           $orden->save();        

            SweetAlert::success('Exito','La orden "'.$orden->nombre.'" ha sido registrada.');
            return Redirect::to('ordenes');
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
        $orden = Orden::findOrFail($id);
        return View::make('actividad.ordenes.show')->with(compact('orden'));
        
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
        $orden = Orden::findOrFail($id);
        $editar = true;
        $paises = XPais::orderBy('nombre', 'asc')->get();
        $estados = Orden::getEstados();
        $clientes = DB::table('clientes')
        ->join('personas', 'clientes.persona_id', '=', 'personas.id')
        ->select('clientes.id', 'personas.primer_nombre', 'personas.segundo_nombre', 'personas.primer_apellido', 'personas.segundo_apellido')
        ->whereIn('clientes.persona_id',Persona::distinct()->select('id')->whereIn('usuario_id',User::distinct()->select('id')->whereHas('roles', function ($query) {
            $query->where('name', '=', 'ROLE_CLIENTE');
})))->get();
        return View::make('actividad.ordenes.edit')->with(compact('orden','editar','paises','clientes','estados'));
   
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
            'nombre'                   => 'required|max:50',
                'barrio'                   => 'required|max:50',
            'direccion'                   => 'required|max:50',
            'latitud'                   => 'required|max:50',
            'longitud'                   => 'required|max:50',
            'ciudad_id'              => 'required',
            'fecha_inicio'                   => 'required|date'
    );

    $validator = Validator::make($request->all(), $rules);


    if ($validator->fails()) {
        SweetAlert::error('Error','Errores en el formulario.');
        return Redirect::to('ordenes/'+$id+'/edit')
            ->withErrors($validator);
    } else {
        $orden = Orden::findOrFail($request->id);
        $ubicacion = new XUbicacion;
        $cliente = Cliente::findOrFail($request->cliente_id);
        $ciudad = XCiudad::findOrFail($request->ciudad_id);
        $ubicacion->latitud = $request->latitud;
        $ubicacion->longitud = $request->longitud;
        $ubicacion->save();        
        $orden->nombre = $request->nombre; 
        $orden->estado = $request->estado;
        $orden->barrio = $request->barrio;
        $orden->direccion = $request->direccion;   
        $orden->fecha_inicio = $request->fecha_inicio;
        $orden->fecha_fin = $request->fecha_fin;
        $orden->ciudad()->associate($ciudad);
        $orden->cliente()->associate($cliente);
        $orden->ubicacion()->associate($ubicacion);
        $orden->save();
        SweetAlert::success('Exito','La orden "'.$orden->nombre.'" ha sido editada.');
        return Redirect::to('ordenes');
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
        $orden = Orden::findOrFail($id);   
        $orden->delete();
        SweetAlert::success('Exito','La orden "'.$orden->nombre.'" ha sido eliminada.');
        return Redirect::to('ordenes');
}

}