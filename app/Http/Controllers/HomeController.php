<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Actividad\Orden;
use Illuminate\Support\Facades\View;
use DB;

class HomeController extends Controller
{
     protected $redirectTo = '/login';
     private $blue = '#1565c0'; //blue darken-3
     private $teal = '#00695c'; //teal darken-3
     private $red = '#c62828'; //red darken-3
     private $amber = '#ff8f00'; //amber darken-3
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
    public function index($estado = null)
    {
        Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR','ROLE_COLABORADOR','ROLE_CLIENTE'],TRUE);
       
       if(Auth::user()->authorizeRoles(['ROLE_COLABORADOR','ROLE_CLIENTE'],FALSE)){
        $estados = Orden::getEstados();
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
            ,ordenes.barrio AS barrio,ordenes.direccion AS direccion
            ,ciudades.nombre AS ciudad,departamentos.nombre AS departamento,paises.nombre AS pais
            ,ubicaciones.latitud AS latitud,ubicaciones.longitud AS longitud
            ,personas.primer_nombre AS primer_nombre,personas.segundo_nombre AS segundo_nombre
            ,personas.primer_apellido AS primer_apellido,personas.segundo_apellido AS segundo_apellido"))
            ->join('ciudades', 'ordenes.ciudad_id', '=', 'ciudades.id')
            ->join('departamentos', 'ciudades.departamento_id', '=', 'departamentos.id')
            ->join('paises', 'departamentos.pais_id', '=', 'paises.id')
            ->join('ubicaciones', 'ordenes.ubicacion_id', '=', 'ubicaciones.id')
            ->join('clientes', 'ordenes.cliente_id', '=', 'clientes.id')
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
        }

        if($estado){
            $ordenes = $ordenes->where('estado','=',$estado);
            $JSON_ordenes = $JSON_ordenes->where('estado','=',$estado);
        }else{
            $ordenes = $ordenes->orderBy("estado");
            $JSON_ordenes = $JSON_ordenes->orderBy("estado");
        }

        $ordenes = $ordenes->get();
        $JSON_ordenes = $JSON_ordenes->get();
        $route = 'home';
        return View::make('home.index')->with(compact('ordenes','JSON_ordenes','estados','estado','route'));
        }
        else if(Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR'],FALSE)){
            return View::make('home.index');
        }
    }

}
