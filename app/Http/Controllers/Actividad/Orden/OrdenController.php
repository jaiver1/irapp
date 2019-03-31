<?php

namespace App\Http\Controllers\Actividad\Orden;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Actividad\Orden;
use App\Models\Actividad\Detalle_orden;
use App\Models\Dato_basico\Ubicacion;
use App\Models\Dato_basico\Direccion;
use App\Models\Dato_basico\Pais;
use App\Models\Dato_basico\Ciudad;
use App\Models\Root\User;
use App\Models\Contacto\Cliente;
use App\Models\Contacto\Colaborador;
use App\Models\Contacto\Persona;
use App\Models\Actividad\Servicio;
use Illuminate\Support\Facades\Validator;
Use SweetAlert;
Use DB;
use Carbon\Carbon;


class OrdenController extends Controller
{
    protected $redirectTo = '/login';
    
    private $blue = '#1565c0'; //blue darken-3
    private $teal = '#00897b'; //teal darken-1
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
    public function index($estado = null)
    {
        Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR'],TRUE);
        $estados_ordenes = Orden::getEstados();
        $ordenes = Orden::select('*');
        $JSON_ordenes = Orden::select(DB::raw(
            "ordenes.id AS id,ordenes.nombre AS title,
            REPLACE(ordenes.fecha_inicio,' ','T') AS start,
            CASE ordenes.estado
            WHEN 'Abierta' THEN '$this->blue'
            WHEN 'Cerrada' THEN '$this->teal'
            WHEN 'Cancelada' THEN '$this->red'
            ELSE '$this->amber'
            END AS color,
            CASE ordenes.estado
            WHEN 'Abierta' THEN 'fa-business-time'
            WHEN 'Cerrada' THEN 'fa-flag-checkered'
            WHEN 'Cancelada' THEN 'fa-times'
            ELSE 'fa-stopwatch'
            END AS icon
            ,ordenes.estado AS estado
            ,ordenes.fecha_inicio AS fecha_inicio ,ordenes.fecha_fin AS fecha_fin
            ,direcciones.barrio AS barrio,direcciones.direccion AS direccion
            ,ciudades.nombre AS ciudad,departamentos.nombre AS departamento,paises.nombre AS pais
            ,ubicaciones.latitud AS latitud,ubicaciones.longitud AS longitud
            ,personas.primer_nombre AS primer_nombre,personas.segundo_nombre AS segundo_nombre
            ,personas.primer_apellido AS primer_apellido,personas.segundo_apellido AS segundo_apellido"))
            ->join('direcciones', 'ordenes.direccion_id', '=', 'direcciones.id')
            ->join('ciudades', 'direcciones.ciudad_id', '=', 'ciudades.id')
            ->join('departamentos', 'ciudades.departamento_id', '=', 'departamentos.id')
            ->join('paises', 'departamentos.pais_id', '=', 'paises.id')
            ->join('ubicaciones', 'direcciones.ubicacion_id', '=', 'ubicaciones.id')
            ->join('clientes', 'ordenes.cliente_id', '=', 'clientes.id')
            ->join('personas', 'clientes.persona_id', '=', 'personas.id');

        if($estado){           
            $ordenes = $ordenes->where('estado','=',$estado);
            $JSON_ordenes = $JSON_ordenes->where('estado','=',$estado);
        }else{
            $ordenes = $ordenes->orderBy("estado");
            $JSON_ordenes = $JSON_ordenes->orderBy("estado");
        }

        $ordenes = $ordenes->get();
        $JSON_ordenes = $JSON_ordenes->get();
        $route = 'ordenes.index';
        return View::make('actividad.ordenes.index')->with(compact('ordenes','JSON_ordenes','estado','estados_ordenes','route'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create($fecha = null)
    {
        Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR'],TRUE);
        $orden = new Orden;
        $cliente =new Cliente;
        $direccion = new Direccion;
        $cliente->persona()->associate(new Persona);
        $direccion->ciudad()->associate(new Ciudad);
        $direccion->ubicacion()->associate(new Ubicacion);
        $orden->direccion()->associate($direccion);
        $orden->cliente()->associate($cliente);
        $orden->fecha_inicio = $fecha;
        $estados_ordenes = Orden::getEstados();
        $editar = false;
        $paises = Pais::orderBy('nombre', 'asc')->get();
        $clientes = DB::table('clientes')
        ->join('personas', 'clientes.persona_id', '=', 'personas.id')
        ->join('users', 'personas.usuario_id', '=', 'users.id')
        ->join('direcciones', 'personas.direccion_id', '=', 'direcciones.id')
        ->join('ciudades', 'direcciones.ciudad_id', '=', 'ciudades.id')
        ->select('clientes.id', 'personas.cedula', 'personas.primer_nombre', 'personas.segundo_nombre', 'personas.primer_apellido', 'personas.segundo_apellido'
        , 'personas.telefono_movil', 'personas.telefono_fijo', 'direcciones.barrio', 'direcciones.direccion', 'personas.cuenta_banco'
        , 'ciudades.nombre AS ciudad', 'users.email AS email')
        ->whereIn('clientes.persona_id',Persona::distinct()->select('id')->whereIn('usuario_id',User::distinct()->select('id')->whereHas('roles', function ($query) {
            $query->where('name', '=', 'ROLE_CLIENTE');
})))->get();
       return View::make('actividad.ordenes.create')->with(compact('orden','editar','paises','clientes','estados_ordenes'));
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
            $direccion = new Direccion;
            $cliente = Cliente::findOrFail($request->cliente_id);
            $ciudad = Ciudad::findOrFail($request->ciudad_id);
            $ubicacion->latitud = $request->latitud;
            $ubicacion->longitud = $request->longitud;
            $ubicacion->save();        
            $orden->nombre = $request->nombre;   
            $orden->fecha_inicio = $request->fecha_inicio;
$carbon_fecha = Carbon::parse($orden->fecha_inicio);
            if($carbon_fecha->isFuture()){
                $orden->estado = "Pendiente";
            }else{
                $orden->estado = "Abierta";
            }

            $orden->cliente()->associate($cliente);
            $direccion->barrio = $request->barrio;
            $direccion->direccion = $request->direccion;
            $direccion->ciudad()->associate($ciudad);
            $direccion->ubicacion()->associate($ubicacion);
            $direccion->save();
            $orden->direccion()->associate($direccion);
           $orden->save();        

            SweetAlert::success('Exito','La orden "'.$orden->nombre.'" ha sido registrada.');
            return Redirect::to('ordenes/index/Abierta');
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
        Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR','ROLE_COLABORADOR','ROLE_CLIENTE'],TRUE);

        $orden = Orden::findOrFail($id);
        $estados_ordenes = Orden::getEstados();
        $paises = Pais::orderBy('nombre', 'asc')->get();
        
        return View::make('actividad.ordenes.show')->with(compact('orden','estados_ordenes','paises'));
        
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
        $orden = Orden::findOrFail($id);
        $editar = true;
        $paises = Pais::orderBy('nombre', 'asc')->get();
        $estados_ordenes = Orden::getEstados();
        $clientes = DB::table('clientes')
        ->join('personas', 'clientes.persona_id', '=', 'personas.id')
        ->join('users', 'personas.usuario_id', '=', 'users.id')
        ->join('direcciones', 'personas.direccion_id', '=', 'direcciones.id')
        ->join('ciudades', 'direcciones.ciudad_id', '=', 'ciudades.id')
        ->select('clientes.id', 'personas.cedula', 'personas.primer_nombre', 'personas.segundo_nombre', 'personas.primer_apellido', 'personas.segundo_apellido'
        , 'personas.telefono_movil', 'personas.telefono_fijo', 'direcciones.barrio', 'direcciones.direccion', 'personas.cuenta_banco'
        , 'ciudades.nombre AS ciudad', 'users.email AS email')
        ->whereIn('clientes.persona_id',Persona::distinct()->select('id')->whereIn('usuario_id',User::distinct()->select('id')->whereHas('roles', function ($query) {
            $query->where('name', '=', 'ROLE_CLIENTE');
})))->get();
        return View::make('actividad.ordenes.edit')->with(compact('orden','editar','paises','clientes','estados_ordenes'));
   
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
        $orden = Orden::findOrFail($id);
        $direccion = Direccion::findOrFail($orden->direccion_id);
        $ubicacion = Ubicacion::findOrFail($direccion->ubicacion_id);
        $cliente = Cliente::findOrFail($request->cliente_id);
        $ciudad = Ciudad::findOrFail($request->ciudad_id);
        $ubicacion->latitud = $request->latitud;
        $ubicacion->longitud = $request->longitud;
        $ubicacion->save();       
        $orden->nombre = $request->nombre; 
        $orden->estado = $request->estado; 
        $orden->fecha_inicio = $request->fecha_inicio;
        
        if($orden->estado == "Cerrada"){
            $orden->fecha_fin = Carbon::now()->format('Y-m-d H:i');
        }else{
            $orden->fecha_fin = NULL;
        }
        $orden->cliente()->associate($cliente);
            $direccion->barrio = $request->barrio;
            $direccion->direccion = $request->direccion;
            $direccion->ciudad()->associate($ciudad);
            $direccion->ubicacion()->associate($ubicacion);
            $direccion->save();
            $orden->direccion()->associate($direccion);
        $orden->save();
        SweetAlert::success('Exito','La orden "'.$orden->nombre.'" ha sido editada.');
        return Redirect::to('ordenes/index/Abierta');
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
        $orden = Orden::findOrFail($id);   
        $orden->delete();
        SweetAlert::success('Exito','La orden "'.$orden->nombre.'" ha sido eliminada.');
        return Redirect::to('ordenes/index/Abierta');
}

/**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function get_detalles($id)
    {  
        Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR','ROLE_COLABORADOR','ROLE_CLIENTE'],TRUE);


            $orden = Orden::findOrFail($id);
            $estados_ordenes = Orden::getEstados();
        return View::make('include.actividad.detalles_ordenes.datatable')->with(compact('orden','estados_ordenes'));

        }

        public function get_servicios($id,$editar)
    {  
        Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR'],TRUE);

            $servicios = Servicio::whereNotIn('id', function($query) use ($id){
                $query->select('servicio_id')->from('detalles_ordenes')
                ->where('orden_id','=',$id)->distinct();
            })->get();
            $detalle_orden = true;
            $prefix = ($editar) ? "edit_" : "";
        return View::make('include.actividad.servicios.modal_search')->with(compact('servicios','detalle_orden','prefix'));
       
        }

        public function get_colaboradores($id,$editar)
        {  
            Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR'],TRUE);
    
            $colaboradores = DB::table('colaboradores')
            ->join('personas', 'colaboradores.persona_id', '=', 'personas.id')
            ->join('users', 'personas.usuario_id', '=', 'users.id')
            ->join('ciudades', 'personas.ciudad_id', '=', 'ciudades.id')
            ->select('colaboradores.id', 'personas.cedula', 'personas.primer_nombre', 'personas.segundo_nombre', 'personas.primer_apellido', 'personas.segundo_apellido'
            , 'personas.telefono_movil', 'personas.telefono_fijo', 'personas.barrio', 'personas.direccion', 'personas.cuenta_banco'
            , 'ciudades.nombre AS ciudad', 'users.email AS email')
            ->whereIn('colaboradores.persona_id',Persona::distinct()->select('id')->whereIn('usuario_id',User::distinct()->select('id')->whereHas('roles', function ($query) {
                $query->where('name', '=', 'ROLE_COLABORADOR');
    })))->whereIn('colaboradores.id',DB::table('colaborador_servicio')->distinct()
    ->select('colaborador_id')->where('servicio_id','=', $id))
    ->get();
    $prefix = ($editar) ? "edit_" : "";
            return View::make('include.contacto.colaboradores.modal_search')->with(compact('colaboradores','prefix'));
            }

            public function form_detalles($id,$editar)
        {  
            Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR'],TRUE);
    
            if($editar){        
                $detalle = Detalle_orden::findOrFail($id); 
                $orden = Orden::findOrFail($detalle->orden_id);
                $prefix = "edit_";
            }else{
                $orden = Orden::findOrFail($id);
                $detalle = new Detalle_orden; 
                $prefix = "";
            }

            $estados_ordenes = Orden::getEstados();
            return View::make('include.actividad.detalles_ordenes.form')->with(compact('orden','detalle','editar','estados_ordenes','prefix'));
            }

            

        public function add_detalles(Request $request)
        {  
            Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR'],TRUE);
            try{
                $rules = array(
                    'nombre'                   => 'required|max:50',
                    'valor_unitario'                   => 'numeric|required|digits_between:1,12',
                    'cantidad'                   => 'numeric|required|digits_between:1,12',
                'orden_id'                   => 'required',
                'servicio_id'                   => 'required',
                'colaborador_id'                   => 'required',
                'fecha_inicio'                   => 'required|date'         
                  );
    
            $validator = Validator::make($request->all(), $rules);
    
    
            if ($validator->fails()) {
                return response()->json(['status'=>500,'message'=>"Error en el formulario",'messageJSON'=>$validator]);
            }else{
                $detalle = new Detalle_orden;
                $orden = Orden::findOrFail($request->orden_id);
                $colaborador = Colaborador::findOrFail($request->colaborador_id);
                $servicio = Servicio::findOrFail($request->servicio_id);
                $detalle->nombre = $request->nombre;
                $detalle->valor_unitario = $request->valor_unitario;
                $detalle->cantidad = $request->cantidad;
                $detalle->fecha_inicio = $request->fecha_inicio;
                $carbon_fecha = Carbon::parse($detalle->fecha_inicio);
                            if($carbon_fecha->isFuture()){
                                $detalle->estado = "Pendiente";
                            }else{
                                $detalle->estado = "Abierta";
                            }
                $detalle->orden()->associate($orden);
                $detalle->colaborador()->associate($colaborador);
                $detalle->servicio()->associate($servicio);
                $detalle->save();
                return response()->json(['status'=>200,'message'=>'El detalle "'.$detalle->nombre.'" ha sido registrado.']);
               
        }

        } catch (Throwable $e) {
            return response()->json(['status'=>500,'message'=>$e->getMessage()]);
        } 
            }


        

                public function update_detalles($id,Request $request)
                {  
                    Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR'],TRUE);
                    try{
                        $rules = array(
                            'edit_nombre'                   => 'required|max:50',
                            'edit_valor_unitario'                   => 'numeric|required|digits_between:1,12',
                            'edit_cantidad'                   => 'numeric|required|digits_between:1,12',
                        'edit_servicio_id'                   => 'required',
                        'edit_colaborador_id'                   => 'required',
                        'edit_fecha_inicio'                   => 'required|date',
                        'edit_fecha_fin'                 => 'required|date'          
                          );
            
                    $validator = Validator::make($request->all(), $rules);
            
            
                    if ($validator->fails()) {
                        return response()->json(['status'=>500,'message'=>"Error en el formulario",'messageJSON'=>$validator]);
                    }else{
                        $detalle = Detalle_orden::findOrFail($id);
                        $colaborador = Colaborador::findOrFail($request->edit_colaborador_id);
                        $servicio = Servicio::findOrFail($request->edit_servicio_id);
                        $detalle->nombre = $request->edit_nombre;
                        $detalle->valor_unitario = $request->edit_valor_unitario;
                        $detalle->cantidad = $request->edit_cantidad;
                        $detalle->fecha_inicio = $request->edit_fecha_inicio;
                        $detalle->estado = $request->edit_estado;
                        if($detalle->estado == "Cerrada"){
                            $detalle->fecha_fin = $request->edit_fecha_fin;
                        }else{
                            $detalle->fecha_fin = NULL;
                        }
                        $detalle->colaborador()->associate($colaborador);
                        $detalle->servicio()->associate($servicio);
                        $detalle->save();
                        return response()->json(['status'=>200,'message'=>'El detalle "'.$detalle->nombre.'" ha sido editado.']);
                       
                }
        
                } catch (Throwable $e) {
                    return response()->json(['status'=>500,'message'=>$e->getMessage()]);
                } 
                    }
    

            public function delete_detalles(Request $request)
            {  
                Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR'],TRUE);
                try{
                    $rules = array(
                        'detalle'                   => 'numeric|required'          
                      );
        
                $validator = Validator::make($request->all(), $rules);
        
        
                if ($validator->fails()) {
                    return response()->json(['status'=>500,'message'=>$validator]);
                }else{
                    $detalle = Detalle_orden::findOrFail($request->detalle);
                    $orden = Colaborador::findOrFail($detalle->id_orden);
                    $orden->detalles()->detach($detalle);
                    return response()->json(['status'=>200,'message'=>'El detalle "'.$detalle->nombre.'" ha sido eliminado.']);
                   
            }
    
            } catch (Throwable $e) {
                return response()->json(['status'=>500,'message'=>$e->getMessage()]);
            } 
                }

}