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
        $ordenes = DB::table('ordenes');
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
        "));
        
        if($estado){
            $ordenes = $ordenes->where('estado','=',$estado);
            $eventos = $eventos->where('estado','=',$estado);
        }
        
        if(Auth::user()->authorizeRoles('ROLE_COLABORADOR',FALSE)){
            $colaborador = Auth::user()->getColaborador();      
            $ordenes = $ordenes->where('cliente_id','=',$colaborador->id);
            $eventos = $eventos->where('cliente_id','=',$colaborador->id);
        }
        else if(Auth::user()->authorizeRoles('ROLE_CLIENTE',FALSE)){
            $cliente = Auth::user()->getCliente();          
            $ordenes = $ordenes->where('cliente_id','=',$cliente->id);
            $eventos = $eventos->where('cliente_id','=',$cliente->id);
        }

        $ordenes = $ordenes->orderBy("estado")->get();
        $eventos = $eventos->get();
        $route = 'home';
        return View::make('home.index')->with(compact('ordenes','eventos','estados','estado','route'));
        }
        else if(Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR'],FALSE)){
            return View::make('home.index');
        }
    }

}
