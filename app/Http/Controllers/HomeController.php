<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Actividad\Orden;
use App\Models\Comercio\Venta;
use App\Models\Actividad\Solicitud;
use Illuminate\Support\Facades\View;
use DB;

class HomeController extends Controller
{
     protected $redirectTo = '/login';
     private $blue = '#1565c0'; //blue darken-3
     private $teal = '#00897b'; //teal darken-1
     private $red = '#c62828'; //red darken-3
     private $amber = '#ff8f00'; //amber darken-3
     private $cyan = '#0097a7'; //cyan darken-2
    private $indigo = '#3f51b5'; //indigo
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($estado = null,Request $request)
    {
        Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR','ROLE_COLABORADOR','ROLE_CLIENTE'],TRUE);
       
       if(Auth::user()->authorizeRoles(['ROLE_COLABORADOR','ROLE_CLIENTE'],FALSE)){

        if($request->input('lapTransactionState')){
            $venta = Venta::findOrFail($id);
            $venta->estado = "Abierta";
            $venta->save();
                    }
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

                $estados_compras= Venta::getEstados();
            $compras = Venta::select('*');
            $JSON_compras = Venta::select(DB::raw(
                "ventas.id AS id,ventas.id AS title,
                REPLACE(ventas.fecha,' ','T') AS start,
                CASE ventas.estado
                WHEN 'Abierta' THEN '$this->teal'
            WHEN 'Cancelada' THEN '$this->red'
            WHEN 'Entregado' THEN '$this->indigo'
            WHEN 'Enviado' THEN '$this->cyan'
                ELSE '$this->amber'
                END AS color,
                CASE ventas.estado
                WHEN 'Abierta' THEN 'fa-calendar-check'
                WHEN 'Cancelada' THEN 'fa-calendar-times'
                WHEN 'Entregado' THEN 'fa-handshake'
                WHEN 'Enviado' THEN 'fa-truck-loading'
                ELSE 'fa-stopwatch'
                END AS icon
                ,ventas.estado AS estado
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

        if(Auth::user()->authorizeRoles('ROLE_COLABORADOR',FALSE)){
            $colaborador = Auth::user()->getColaborador();      
            $ordenes = $ordenes->where('cliente_id','=',$colaborador->id);
            $JSON_ordenes = $JSON_ordenes->where('cliente_id','=',$colaborador->id);
        }
        else if(Auth::user()->authorizeRoles('ROLE_CLIENTE',FALSE)){
            $cliente = Auth::user()->getCliente();          
            $ordenes = $ordenes->where('cliente_id','=',$cliente->id);
            $JSON_ordenes = $JSON_ordenes->where('cliente_id','=',$cliente->id);
            $compras = $compras->where('cliente_id','=',$cliente->id);
            $JSON_compras = $JSON_compras->where('cliente_id','=',$cliente->id);
        }

        if($estado){
            $ordenes = $ordenes->where('estado','=',$estado);
            $JSON_ordenes = $JSON_ordenes->where('estado','=',$estado);

            $solicitudes = $solicitudes->where('estado','=',$estado);
            $JSON_solicitudes = $JSON_solicitudes->where('estado','=',$estado);

            $compras = $compras->where('estado','=',$estado);
            $JSON_compras = $JSON_compras->where('estado','=',$estado);
        }else{
            $ordenes = $ordenes->orderBy("estado");
            $JSON_ordenes = $JSON_ordenes->orderBy("estado");

            $solicitudes = $solicitudes->orderBy("estado");
            $JSON_solicitudes = $JSON_solicitudes->orderBy("estado");

            $compras = $compras->orderBy("estado");
            $JSON_compras = $JSON_compras->orderBy("estado");
        }
        $compras = $compras->get();
        $JSON_compras = $JSON_compras->get(); 
        $ordenes = $ordenes->get();
        $JSON_ordenes = $JSON_ordenes->get();
        $solicitudes = $solicitudes->get();
        $JSON_solicitudes = $JSON_solicitudes->get();
        $route = 'home';
        return View::make('home.index')->with(compact('ordenes','JSON_ordenes','estados_ordenes','solicitudes','JSON_solicitudes','estados_solicitudes','estado','route','compras','JSON_compras','estados_compras'));
        }
        else if(Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR'],FALSE)){
            $JSON_ordenes = Orden::selectRaw('estado AS name, count(*) AS y')->groupBy('estado')->get();
            $JSON_solicitudes = Solicitud::selectRaw('estado AS name, count(*) AS y')->groupBy('estado')->get();
            $JSON_ventas = Venta::selectRaw('estado AS name, count(*) AS y')->groupBy('estado')->get();
            
            return View::make('home.index')->with(compact('JSON_ordenes','JSON_solicitudes','JSON_ventas'));
        }
    }

}
