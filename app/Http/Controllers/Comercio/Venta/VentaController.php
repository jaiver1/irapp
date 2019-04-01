<?php

namespace App\Http\Controllers\Comercio\Venta;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Comercio\Venta;
use App\Models\Comercio\Detalle_venta;
use App\Models\Dato_basico\Ubicacion;
use App\Models\Dato_basico\Direccion;
use App\Models\Dato_basico\Pais;
use App\Models\Dato_basico\Ciudad;
use App\Models\Root\User;
use App\Models\Contacto\Cliente;
use App\Models\Contacto\Colaborador;
use App\Models\Contacto\Persona;
use App\Models\Comercio\Servicio;
use Illuminate\Support\Facades\Validator;
Use SweetAlert;
Use DB;
use Carbon\Carbon;


class VentaController extends Controller
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
        $estados_ventas = Venta::getEstados();
        $ventas = Venta::select('*');
        $JSON_ventas = Venta::select(DB::raw(
            "ventas.id AS id,ventas.nombre AS title,
            REPLACE(ventas.fecha_inicio,' ','T') AS start,
            CASE ventas.estado
            WHEN 'Abierta' THEN '$this->teal'
            WHEN 'Cancelada' THEN '$this->red'
            ELSE '$this->amber'
            END AS color,
            CASE ventas.estado
            WHEN 'Abierta' THEN 'fa-calendar-check'
            WHEN 'Cancelada' THEN 'fa-calendar-times'
            ELSE 'fa-stopwatch'
            END AS icon
            ,ventas.estado AS estado
            ,ventas.fecha_inicio AS fecha_inicio ,ventas.fecha_fin AS fecha_fin
            ,direcciones.barrio AS barrio,direcciones.direccion AS direccion
            ,ciudades.nombre AS ciudad,departamentos.nombre AS departamento,paises.nombre AS pais
            ,ubicaciones.latitud AS latitud,ubicaciones.longitud AS longitud
            ,personas.primer_nombre AS primer_nombre,personas.segundo_nombre AS segundo_nombre
            ,personas.primer_apellido AS primer_apellido,personas.segundo_apellido AS segundo_apellido"))
            ->join('direcciones', 'ventas.direccion_id', '=', 'direcciones.id')
            ->join('ciudades', 'direcciones.ciudad_id', '=', 'ciudades.id')
            ->join('departamentos', 'ciudades.departamento_id', '=', 'departamentos.id')
            ->join('paises', 'departamentos.pais_id', '=', 'paises.id')
            ->join('ubicaciones', 'direcciones.ubicacion_id', '=', 'ubicaciones.id')
            ->join('clientes', 'ventas.cliente_id', '=', 'clientes.id')
            ->join('personas', 'clientes.persona_id', '=', 'personas.id');

        if($estado){           
            $ventas = $ventas->where('estado','=',$estado);
            $JSON_ventas = $JSON_ventas->where('estado','=',$estado);
        }else{
            $ventas = $ventas->orderBy("estado");
            $JSON_ventas = $JSON_ventas->orderBy("estado");
        }

        $ventas = $ventas->get();
        $JSON_ventas = $JSON_ventas->get();
        $route = 'ventas.index';
        return View::make('comercio.ventas.index')->with(compact('ventas','JSON_ventas','estado','estados_ventas','route'));
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
            return Redirect::to('ventas/create')
                ->withErrors($validator);
        } else {
            $venta = new Venta;
            $ubicacion = new Ubicacion;
            $direccion = new Direccion;
            $cliente = Cliente::findOrFail($request->cliente_id);
            $ciudad = Ciudad::findOrFail($request->ciudad_id);
            $ubicacion->latitud = $request->latitud;
            $ubicacion->longitud = $request->longitud;
            $ubicacion->save();        
            $venta->nombre = $request->nombre;   
            $venta->fecha_inicio = $request->fecha_inicio;
$carbon_fecha = Carbon::parse($venta->fecha_inicio);
            if($carbon_fecha->isFuture()){
                $venta->estado = "Pendiente";
            }else{
                $venta->estado = "Abierta";
            }

            $venta->cliente()->associate($cliente);
            $direccion->barrio = $request->barrio;
            $direccion->direccion = $request->direccion;
            $direccion->ciudad()->associate($ciudad);
            $direccion->ubicacion()->associate($ubicacion);
            $direccion->save();
            $venta->direccion()->associate($direccion);
           $venta->save();        

            SweetAlert::success('Exito','La venta "'.$venta->nombre.'" ha sido registrada.');
            return Redirect::to('ventas/index/Abierta');
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

        $venta = Venta::findOrFail($id);
        
        return View::make('comercio.ventas.show')->with(compact('venta'));
        
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
        return Redirect::to('ventas/'+$id+'/edit')
            ->withErrors($validator);
    } else { 
        $venta = Venta::findOrFail($id);
        $direccion = Direccion::findOrFail($venta->direccion_id);
        $ubicacion = Ubicacion::findOrFail($direccion->ubicacion_id);
        $cliente = Cliente::findOrFail($request->cliente_id);
        $ciudad = Ciudad::findOrFail($request->ciudad_id);
        $ubicacion->latitud = $request->latitud;
        $ubicacion->longitud = $request->longitud;
        $ubicacion->save();       
        $venta->nombre = $request->nombre; 
        $venta->estado = $request->estado; 
        $venta->fecha_inicio = $request->fecha_inicio;
        
        if($venta->estado == "Cerrada"){
            $venta->fecha_fin = Carbon::now()->format('Y-m-d H:i');
        }else{
            $venta->fecha_fin = NULL;
        }
        $venta->cliente()->associate($cliente);
            $direccion->barrio = $request->barrio;
            $direccion->direccion = $request->direccion;
            $direccion->ciudad()->associate($ciudad);
            $direccion->ubicacion()->associate($ubicacion);
            $direccion->save();
            $venta->direccion()->associate($direccion);
        $venta->save();
        SweetAlert::success('Exito','La venta "'.$venta->nombre.'" ha sido editada.');
        return Redirect::to('ventas/index/Abierta');
    }
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


            $venta = Venta::findOrFail($id);
            $estados_ventas = Venta::getEstados();
        return View::make('include.comercio.detalles_ventas.datatable')->with(compact('venta','estados_ventas'));

        }

        public function get_servicios($id,$editar)
    {  
        Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR'],TRUE);

            $servicios = Servicio::whereNotIn('id', function($query) use ($id){
                $query->select('servicio_id')->from('detalles_ventas')
                ->where('venta_id','=',$id)->distinct();
            })->get();
            $detalle_venta = true;
            $prefix = ($editar) ? "edit_" : "";
        return View::make('include.comercio.servicios.modal_search')->with(compact('servicios','detalle_venta','prefix'));
       
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
                $detalle = Detalle_venta::findOrFail($id); 
                $venta = Venta::findOrFail($detalle->venta_id);
                $prefix = "edit_";
            }else{
                $venta = Venta::findOrFail($id);
                $detalle = new Detalle_venta; 
                $prefix = "";
            }

            $estados_ventas = Venta::getEstados();
            return View::make('include.comercio.detalles_ventas.form')->with(compact('venta','detalle','editar','estados_ventas','prefix'));
            }

            

        public function add_detalles(Request $request)
        {  
            Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR'],TRUE);
            try{
                $rules = array(
                    'nombre'                   => 'required|max:50',
                    'valor_unitario'                   => 'numeric|required|digits_between:1,12',
                    'cantidad'                   => 'numeric|required|digits_between:1,12',
                'venta_id'                   => 'required',
                'servicio_id'                   => 'required',
                'colaborador_id'                   => 'required',
                'fecha_inicio'                   => 'required|date'         
                  );
    
            $validator = Validator::make($request->all(), $rules);
    
    
            if ($validator->fails()) {
                return response()->json(['status'=>500,'message'=>"Error en el formulario",'messageJSON'=>$validator]);
            }else{
                $detalle = new Detalle_venta;
                $venta = Venta::findOrFail($request->venta_id);
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
                $detalle->venta()->associate($venta);
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
                        $detalle = Detalle_venta::findOrFail($id);
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
                    $detalle = Detalle_venta::findOrFail($request->detalle);
                    $venta = Colaborador::findOrFail($detalle->id_venta);
                    $venta->detalles()->detach($detalle);
                    return response()->json(['status'=>200,'message'=>'El detalle "'.$detalle->nombre.'" ha sido eliminado.']);
                   
            }
    
            } catch (Throwable $e) {
                return response()->json(['status'=>500,'message'=>$e->getMessage()]);
            } 
                }

}