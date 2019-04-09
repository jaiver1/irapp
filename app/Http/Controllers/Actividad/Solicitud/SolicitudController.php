<?php

namespace App\Http\Controllers\Actividad\Solicitud;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Actividad\Solicitud;
use App\Models\Actividad\Detalle_solicitud;
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


class SolicitudController extends Controller
{
    protected $redirectTo = '/login';
    
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
        $estados_solicitudes = Solicitud::getEstados();
        $solicitudes = Solicitud::select('*');
        $JSON_solicitudes = Solicitud::select(DB::raw(
            "solicitudes.id AS id,solicitudes.nombre AS title,
            REPLACE(solicitudes.fecha_inicio,' ','T') AS start,
            CASE solicitudes.estado
            WHEN 'Abierta' THEN '$this->teal'
            WHEN 'Cancelada' THEN '$this->red'
            ELSE '$this->amber'
            END AS color,
            CASE solicitudes.estado
            WHEN 'Abierta' THEN 'fa-calendar-check'
            WHEN 'Cancelada' THEN 'fa-calendar-times'
            ELSE 'fa-stopwatch'
            END AS icon
            ,solicitudes.estado AS estado
            ,solicitudes.fecha_inicio AS fecha_inicio ,solicitudes.fecha_fin AS fecha_fin
            ,direcciones.barrio AS barrio,direcciones.direccion AS direccion
            ,ciudades.nombre AS ciudad,departamentos.nombre AS departamento,paises.nombre AS pais
            ,ubicaciones.latitud AS latitud,ubicaciones.longitud AS longitud
            ,personas.primer_nombre AS primer_nombre,personas.segundo_nombre AS segundo_nombre
            ,personas.primer_apellido AS primer_apellido,personas.segundo_apellido AS segundo_apellido"))
            ->join('direcciones', 'solicitudes.direccion_id', '=', 'direcciones.id')
            ->join('ciudades', 'direcciones.ciudad_id', '=', 'ciudades.id')
            ->join('departamentos', 'ciudades.departamento_id', '=', 'departamentos.id')
            ->join('paises', 'departamentos.pais_id', '=', 'paises.id')
            ->join('ubicaciones', 'direcciones.ubicacion_id', '=', 'ubicaciones.id')
            ->join('clientes', 'solicitudes.cliente_id', '=', 'clientes.id')
            ->join('personas', 'clientes.persona_id', '=', 'personas.id');

        if($estado){           
            $solicitudes = $solicitudes->where('estado','=',$estado);
            $JSON_solicitudes = $JSON_solicitudes->where('estado','=',$estado);
        }else{
            $solicitudes = $solicitudes->orderBy("estado");
            $JSON_solicitudes = $JSON_solicitudes->orderBy("estado");
        }

        $solicitudes = $solicitudes->get();
        $JSON_solicitudes = $JSON_solicitudes->get();
        $route = 'solicitudes.index';
        return View::make('actividad.solicitudes.index')->with(compact('solicitudes','JSON_solicitudes','estado','estados_solicitudes','route'));
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
            return Redirect::to('solicitudes/create')
                ->withErrors($validator);
        } else {
            $solicitud = new Solicitud;
            $ubicacion = new Ubicacion;
            $direccion = new Direccion;
            $cliente = Cliente::findOrFail($request->cliente_id);
            $ciudad = Ciudad::findOrFail($request->ciudad_id);
            $ubicacion->latitud = $request->latitud;
            $ubicacion->longitud = $request->longitud;
            $ubicacion->save();        
            $solicitud->nombre = $request->nombre;   
            $solicitud->fecha_inicio = $request->fecha_inicio;
$carbon_fecha = Carbon::parse($solicitud->fecha_inicio);
            if($carbon_fecha->isFuture()){
                $solicitud->estado = "Pendiente";
            }else{
                $solicitud->estado = "Abierta";
            }

            $solicitud->cliente()->associate($cliente);
            $direccion->barrio = $request->barrio;
            $direccion->direccion = $request->direccion;
            $direccion->ciudad()->associate($ciudad);
            $direccion->ubicacion()->associate($ubicacion);
            $direccion->save();
            $solicitud->direccion()->associate($direccion);
           $solicitud->save();        

            SweetAlert::success('Exito','La solicitud "'.$solicitud->nombre.'" ha sido registrada.');
            return Redirect::to('solicitudes/index/Abierta');
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
        Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR','ROLE_CLIENTE'],TRUE);

        $solicitud = Solicitud::findOrFail($id);
        
        return View::make('actividad.solicitudes.show')->with(compact('solicitud'));
        
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
        return Redirect::to('solicitudes/'+$id+'/edit')
            ->withErrors($validator);
    } else { 
        $solicitud = Solicitud::findOrFail($id);
        $direccion = Direccion::findOrFail($solicitud->direccion_id);
        $ubicacion = Ubicacion::findOrFail($direccion->ubicacion_id);
        $cliente = Cliente::findOrFail($request->cliente_id);
        $ciudad = Ciudad::findOrFail($request->ciudad_id);
        $ubicacion->latitud = $request->latitud;
        $ubicacion->longitud = $request->longitud;
        $ubicacion->save();       
        $solicitud->nombre = $request->nombre; 
        $solicitud->estado = $request->estado; 
        $solicitud->fecha_inicio = $request->fecha_inicio;
        
        if($solicitud->estado == "Cerrada"){
            $solicitud->fecha_fin = Carbon::now()->format('Y-m-d H:i');
        }else{
            $solicitud->fecha_fin = NULL;
        }
        $solicitud->cliente()->associate($cliente);
            $direccion->barrio = $request->barrio;
            $direccion->direccion = $request->direccion;
            $direccion->ciudad()->associate($ciudad);
            $direccion->ubicacion()->associate($ubicacion);
            $direccion->save();
            $solicitud->direccion()->associate($direccion);
        $solicitud->save();
        SweetAlert::success('Exito','La solicitud "'.$solicitud->nombre.'" ha sido editada.');
        return Redirect::to('solicitudes/index/Abierta');
    }
    }
    public function approve($id)
    {  
        Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR','ROLE_CLIENTE'],TRUE);
$solicitud = Solicitud::findOrFail($id);

$orden = new Orden;      
            $orden->nombre = $solicitud->nombre;   
            $orden->fecha_inicio = $solicitud->fecha_inicio;
$carbon_fecha = Carbon::parse($orden->fecha_inicio);
            if($carbon_fecha->isFuture()){
                $orden->estado = "Pendiente";
            }else{
                $orden->estado = "Abierta";
            }

            $orden->cliente()->associate($solicitud->cliente);
            $orden->direccion()->associate($solicitud->direccion);
           $orden->save();  
foreach ($solicitud->detalles as $key => $sub) {
    $detalle = new Detalle_orden;
    $detalle->nombre = $orden->nombre;   
    $detalle->fecha_inicio = $orden->fecha_inicio;
    $detalle->estado = $orden->estado;
    $detalle->cantidad =  $sub->cantidad;
    $detalle->valor_unitario =  $sub->valor_unitario;
    $detalle->servicio()->associate($sub->servicio);
    $detalle->orden()->associate($orden);
    $detalle->save();  
   }

   $solicitud->estado = "Abierta";
   $solicitud->save();

 return Redirect::to('ordenes/'.$orden->id);
        }

        public function cancel($id)
    {  
        Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR','ROLE_CLIENTE'],TRUE);
        $solicitud = Solicitud::findOrFail($id);
        $solicitud->estado = "Cancelada";
        $solicitud->save();

            return Redirect::to('solicitudes/'.$id);
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


            $solicitud = Solicitud::findOrFail($id);
            $estados_solicitudes = Solicitud::getEstados();
        return View::make('include.actividad.detalles_solicitudes.datatable')->with(compact('solicitud','estados_solicitudes'));

        }

        public function get_servicios($id,$editar)
    {  
        Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR'],TRUE);

            $servicios = Servicio::whereNotIn('id', function($query) use ($id){
                $query->select('servicio_id')->from('detalles_solicitudes')
                ->where('solicitud_id','=',$id)->distinct();
            })->get();
            $detalle_solicitud = true;
            $prefix = ($editar) ? "edit_" : "";
        return View::make('include.actividad.servicios.modal_search')->with(compact('servicios','detalle_solicitud','prefix'));
       
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
                $detalle = Detalle_solicitud::findOrFail($id); 
                $solicitud = Solicitud::findOrFail($detalle->solicitud_id);
                $prefix = "edit_";
            }else{
                $solicitud = Solicitud::findOrFail($id);
                $detalle = new Detalle_solicitud; 
                $prefix = "";
            }

            $estados_solicitudes = Solicitud::getEstados();
            return View::make('include.actividad.detalles_solicitudes.form')->with(compact('solicitud','detalle','editar','estados_solicitudes','prefix'));
            }

            

        public function add_detalles(Request $request)
        {  
            Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR'],TRUE);
            try{
                $rules = array(
                    'nombre'                   => 'required|max:50',
                    'valor_unitario'                   => 'numeric|required|digits_between:1,12',
                    'cantidad'                   => 'numeric|required|digits_between:1,12',
                'solicitud_id'                   => 'required',
                'servicio_id'                   => 'required',
                'colaborador_id'                   => 'required',
                'fecha_inicio'                   => 'required|date'         
                  );
    
            $validator = Validator::make($request->all(), $rules);
    
    
            if ($validator->fails()) {
                return response()->json(['status'=>500,'message'=>"Error en el formulario",'messageJSON'=>$validator]);
            }else{
                $detalle = new Detalle_solicitud;
                $solicitud = Solicitud::findOrFail($request->solicitud_id);
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
                $detalle->solicitud()->associate($solicitud);
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
                        $detalle = Detalle_solicitud::findOrFail($id);
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
                    $detalle = Detalle_solicitud::findOrFail($request->detalle);
                    $solicitud = Colaborador::findOrFail($detalle->id_solicitud);
                    $solicitud->detalles()->detach($detalle);
                    return response()->json(['status'=>200,'message'=>'El detalle "'.$detalle->nombre.'" ha sido eliminado.']);
                   
            }
    
            } catch (Throwable $e) {
                return response()->json(['status'=>500,'message'=>$e->getMessage()]);
            } 
                }

}