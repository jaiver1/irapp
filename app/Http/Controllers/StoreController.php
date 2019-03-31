<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\Clasificacion\Especialidad;
use App\Models\Clasificacion\Categoria;
use App\Models\Comercio\Producto;
use App\Models\Actividad\Servicio;
use App\Classes\Store\Filter;
use DB;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('store.welcome');
    }

    public function cart_productos()
    {  
        Auth::user()->authorizeRoles('ROLE_CLIENTE',TRUE);
        return View::make('store.productos.cart');
        }

    public function show_productos($id)
    {  
        $producto = Producto::findOrFail($id);
        return View::make('store.productos.show')->with(compact('producto'));
        }

        public function show_servicios($id)
        {  
            $producto = Producto::findOrFail($id);
            return View::make('store.productos.cart')->with(compact('producto'));
            }

            public function cart_servicios()
            {  
                Auth::user()->authorizeRoles('ROLE_CLIENTE',TRUE);
                return View::make('store.servicios.cart');
                }

    
    public function lista_productos(Request $request)
    {
        $productos = Producto::select('*'); 
        $expensive = DB::table('productos');
        $especialidades = Especialidad::all(); 
        $filter = new Filter();

        if($request->input('min')){
            if(is_numeric($request->input('min'))){
                $filter->min = $request->input('min');
                $productos = $productos->where('valor_unitario','>=',$filter->min);
            }   
        }

        if($request->input('max')){
            if(is_numeric($request->input('max'))){
                $filter->max = $request->input('max');
                $productos = $productos->where('valor_unitario','<=',$filter->max);
            }    
        }

        if($request->input('query')){
                $filter->query = $request->input('query');
                $productos = $productos->orWhere('nombre','=',$filter->query);
                $expensive = $expensive->orWhere('nombre','=',$filter->query);
                $productos = $productos->orWhere('descripcion','=',$filter->query);
                $expensive = $expensive->orWhere('descripcion','=',$filter->query);
            }    

            if($request->input('categoria_id')){
                $category = Categoria::find($request->input('categoria_id'));
                if($category){
                    $filter->category = $category;
                    $productos = $productos->where('categoria_id','=',$filter->category->id);
                    $expensive = $expensive->where('categoria_id','=',$filter->category->id);
                }
            } 

            if(Auth::user()->authorizeRoles('ROLE_CLIENTE',FALSE)){
            $sub_query= function($q){
                $q->select('producto_id')
                  ->from('cliente_producto')
                  ->where('cliente_id','=',Auth::user()->getCliente()->id);
            };
            $productos = $productos->whereNotIn('id', $sub_query);
            $expensive = $expensive->whereNotIn('id', $sub_query);
        }

        if($request->input('order')){

            $filter->order = $request->input('order');
            
            if($filter->order == "a-z"){
                $productos = $productos->orderBy('nombre', 'asc');
            }  
            else if($filter->order == "z-a"){
                $productos = $productos->orderBy('nombre', 'desc');
            } 
            else if($filter->order == "min_price"){
            $productos = $productos->orderBy('valor_unitario', 'asc');
            }    
            else if($filter->order == "max_price"){
            $productos = $productos->orderBy('valor_unitario', 'desc');
            }
            else{
                $filter->order = 'latest';
                $productos = $productos->latest();
            }
    }else{
        $filter->order = 'latest';
        $productos = $productos->latest();
    }

    $filter->limit = trim($expensive->max('valor_unitario'));
    $filter->limit = ($filter->limit) ? $filter->limit : 0;

    $filter->min = ($filter->min) ? $filter->min : 0;
    $filter->max = ($filter->max) ? $filter->max : $filter->limit;

        $productos = $productos->paginate(2);

        return View::make('store.productos.list')->with(compact('productos','especialidades','filter'));
    }

    public function lista_servicios(Request $request)
    {
        $servicios = Servicio::select('*'); 
        $expensive = DB::table('servicios');
        $especialidades = Especialidad::all(); 
        $filter = new Filter();

        if($request->input('min')){
            if(is_numeric($request->input('min'))){
                $filter->min = $request->input('min');
                $servicios = $servicios->where('valor_unitario','>=',$filter->min);
            }   
        }

        if($request->input('max')){
            if(is_numeric($request->input('max'))){
                $filter->max = $request->input('max');
                $servicios = $servicios->where('valor_unitario','<=',$filter->max);
            }    
        }

        if($request->input('query')){
                $filter->query = $request->input('query');
                $servicios = $servicios->orWhere('nombre','=',$filter->query);
                $expensive = $expensive->orWhere('nombre','=',$filter->query);
                $servicios = $servicios->orWhere('descripcion','=',$filter->query);
                $expensive = $expensive->orWhere('descripcion','=',$filter->query);
            }    

            if($request->input('categoria_id')){
                $category = Categoria::find($request->input('categoria_id'));
                if($category){
                    $filter->category = $category;
                    $servicios = $servicios->where('categoria_id','=',$filter->category->id);
                    $expensive = $expensive->where('categoria_id','=',$filter->category->id);
                }
            } 

            if(Auth::user()->authorizeRoles('ROLE_CLIENTE',FALSE)){
            $sub_query= function($q){
                $q->select('servicio_id')
                  ->from('cliente_servicio')
                  ->where('cliente_id','=',Auth::user()->getCliente()->id);
            };
            $servicios = $servicios->whereNotIn('id', $sub_query);
            $expensive = $expensive->whereNotIn('id', $sub_query);
        }
        
        if($request->input('order')){

            $filter->order = $request->input('order');
            
            if($filter->order == "a-z"){
                $servicios = $servicios->orderBy('nombre', 'asc');
            }  
            else if($filter->order == "z-a"){
                $servicios = $servicios->orderBy('nombre', 'desc');
            } 
            else if($filter->order == "min_price"){
            $servicios = $servicios->orderBy('valor_unitario', 'asc');
            }    
            else if($filter->order == "max_price"){
            $servicios = $servicios->orderBy('valor_unitario', 'desc');
            }
            else{
                $filter->order = 'latest';
                $servicios = $servicios->latest();
            }
    }else{
        $filter->order = 'latest';
        $servicios = $servicios->latest();
    }

    $filter->limit = trim($expensive->max('valor_unitario'));
    $filter->limit = ($filter->limit) ? $filter->limit : 0;

    $filter->min = ($filter->min) ? $filter->min : 0;
    $filter->max = ($filter->max) ? $filter->max : $filter->limit;

        $servicios = $servicios->paginate(2);

        return View::make('store.servicios.list')->with(compact('servicios','especialidades','filter'));
    }
}
