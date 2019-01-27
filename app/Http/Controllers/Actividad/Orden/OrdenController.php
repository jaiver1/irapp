<?php

namespace App\Http\Controllers\Actividad\Orden;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Actividad\Orden;
use App\Models\Actividad\Servicio;
use App\Models\Dato_basico\Ubicacion;
use App\Models\Dato_basico\Pais;
use App\Models\Dato_basico\Ciudad;
use App\Models\Root\User;
use App\Models\Contacto\Cliente;
use App\Models\Contacto\Persona;
use Illuminate\Support\Facades\Validator;
Use SweetAlert;
Use DB;
use Carbon\Carbon;


class OrdenController extends Controller
{
    protected $redirectTo = '/login';
    
    private $blue = '#1565c0'; //blue darken-3
    private $teal = '#00695c'; //teal darken-3
    private $red = '#c62828'; //red darken-3
    private $amber = '#ff8f00'; //amber darken-3
    
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
        $eventos = Orden::select(DB::raw("id AS id,nombre AS title,
        REPLACE(fecha_inicio,' ','T') AS start,
        CASE estado
        WHEN 'Abierta' THEN '$this->blue'
        WHEN 'Cerrada' THEN '$this->teal'
        WHEN 'Cancelada' THEN '$this->red'
        ELSE '$this->amber'
        END AS color,
        CASE estado
        WHEN 'Abierta' THEN 'fa-business-time'
        WHEN 'Cerrada' THEN 'fa-flag-checkered'
        WHEN 'Cancelada' THEN 'fa-times'
        ELSE 'fa-stopwatch'
        END AS icon
        "))->get();
        //return $eventos;
        return View::make('actividad.ordenes.index')->with(compact('ordenes','eventos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR']);
        $orden = new Orden;
        $cliente =new Cliente;
        $cliente->persona()->associate(new Persona);
        $orden->ciudad()->associate(new Ciudad);
        $orden->ubicacion()->associate(new Ubicacion);
        $orden->cliente()->associate($cliente);
        $estados = Orden::getEstados();
        $editar = false;
        $paises = Pais::orderBy('nombre', 'asc')->get();
        $clientes = DB::table('clientes')
        ->join('personas', 'clientes.persona_id', '=', 'personas.id')
        ->join('users', 'personas.usuario_id', '=', 'users.id')
        ->join('ciudades', 'personas.ciudad_id', '=', 'ciudades.id')
        ->select('clientes.id', 'personas.cedula', 'personas.primer_nombre', 'personas.segundo_nombre', 'personas.primer_apellido', 'personas.segundo_apellido'
        , 'personas.telefono_movil', 'personas.telefono_fijo', 'personas.barrio', 'personas.direccion', 'personas.cuenta_banco'
        , 'ciudades.nombre AS ciudad', 'users.email AS email')
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
            $ubicacion = new Ubicacion;
            $cliente = Cliente::findOrFail($request->cliente_id);
            $ciudad = Ciudad::findOrFail($request->ciudad_id);
            $ubicacion->latitud = $request->latitud;
            $ubicacion->longitud = $request->longitud;
            $ubicacion->save();        
            $orden->nombre = $request->nombre;
            $orden->barrio = $request->barrio;
            $orden->direccion = $request->direccion;   
            $orden->fecha_inicio = $request->fecha_inicio;
$carbon_fecha = Carbon::parse($orden->fecha_inicio);
            if($carbon_fecha->isFuture()){
                $orden->estado = "Pendiente";
            }else{
                $orden->estado = "Abierta";
            }

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
        $servicios = Servicio::all();
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
        $paises = Pais::orderBy('nombre', 'asc')->get();
        $estados = Orden::getEstados();
        $clientes = DB::table('clientes')
        ->join('personas', 'clientes.persona_id', '=', 'personas.id')
        ->join('users', 'personas.usuario_id', '=', 'users.id')
        ->join('ciudades', 'personas.ciudad_id', '=', 'ciudades.id')
        ->select('clientes.id', 'personas.cedula', 'personas.primer_nombre', 'personas.segundo_nombre', 'personas.primer_apellido', 'personas.segundo_apellido'
        , 'personas.telefono_movil', 'personas.telefono_fijo', 'personas.barrio', 'personas.direccion', 'personas.cuenta_banco'
        , 'ciudades.nombre AS ciudad', 'users.email AS email')
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
            'estado'                   => 'required|in:Abierta,Cerrada,Cancelada,Pendiente',
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
        return Redirect::to('ordenes/'+$id+'/edit')
            ->withErrors($validator);
    } else {
        $orden = Orden::findOrFail($request->id);
        $ubicacion = new Ubicacion;
        $cliente = Cliente::findOrFail($request->cliente_id);
        $ciudad = Ciudad::findOrFail($request->ciudad_id);
        $ubicacion->latitud = $request->latitud;
        $ubicacion->longitud = $request->longitud;
        $ubicacion->save();        
        $orden->nombre = $request->nombre; 
        $orden->estado = $request->estado;
        $orden->barrio = $request->barrio;
        $orden->direccion = $request->direccion;   
        $orden->fecha_inicio = $request->fecha_inicio;
        
        if($orden->estado == "Cerrada"){
            $orden->fecha_fin = Carbon::now()->format('Y-m-d H:i');
        }else{
            $orden->fecha_fin = NULL;
        }
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