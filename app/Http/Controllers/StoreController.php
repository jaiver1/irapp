<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\Clasificacion\Categoria;
use App\Models\Comercio\Producto;
use App\Models\Actividad\Servicio;
use App\Models\Actividad\Solicitud;
use App\Models\Actividad\Detalle_solicitud;
use App\Models\Comercio\Venta;
use App\Models\Comercio\Detalle_venta;
use App\Models\Dato_basico\Ubicacion;
use App\Models\Dato_basico\Direccion;
use App\Classes\Store\Filter;
use DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Dato_basico\Pais;
use App\Models\Dato_basico\Ciudad;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
Use SweetAlert;

class StoreController extends Controller
{

    protected $redirectTo = '/login';
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

    public function register_venta(Request $request)
    {  
        if(Auth::user()){
        Auth::user()->authorizeRoles('ROLE_CLIENTE',TRUE);
        $rules = array(
            'barrio'                   => 'required|max:50',
        'direccion'                   => 'required|max:50',
        'latitud'                   => 'required|max:50',
        'longitud'                   => 'required|max:50',
        'ciudad_id'              => 'required'
    );

    $validator = Validator::make($request->all(), $rules);


    if ($validator->fails()) {
        SweetAlert::error('Error','Errores en el formulario.');
        return Redirect::to('store/cart/productos')
            ->withErrors($validator);
    } else {
        $venta = new Venta;
        $ubicacion = new Ubicacion;
        $direccion = new Direccion;
        $cliente = Auth::user()->getCliente();
        $ciudad = Ciudad::findOrFail($request->ciudad_id);
        $ubicacion->latitud = $request->latitud;
        $ubicacion->longitud = $request->longitud;
        $ubicacion->save();          
        $venta->fecha = Carbon::now();
            $venta->estado = "Pendiente";
       

        $venta->cliente()->associate($cliente);
        $direccion->barrio = $request->barrio;
        $direccion->direccion = $request->direccion;
        $direccion->ciudad()->associate($ciudad);
        $direccion->ubicacion()->associate($ubicacion);
        $direccion->save();
        $venta->direccion()->associate($direccion);
        $venta->save();        

       for ($i=0; $i < count($request->cantidad); $i++) { 
        $detalle = new Detalle_venta;
        $detalle->cantidad = $request->cantidad[$i];
        $detalle->valor_unitario = $request->valor[$i];
        $detalle->producto()->associate(Producto::findOrFail($request->producto[$i]));
        $detalle->venta()->associate($venta);
        $detalle->save();  
       }

       Auth::user()->getCliente()->productos()->detach();

        SweetAlert::success('Exito','La venta ha sido registrada.');
        return Redirect::to('home');
    }
    }else{
        abort(403);
                        }
        }

    public function register_solicitud(Request $request)
    {  
        if(Auth::user()){
        Auth::user()->authorizeRoles('ROLE_CLIENTE',TRUE);
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
        return Redirect::to('store/cart/servicios')
            ->withErrors($validator);
    } else {
        $solicitud = new Solicitud;
        $ubicacion = new Ubicacion;
        $direccion = new Direccion;
        $cliente = Auth::user()->getCliente();
        $ciudad = Ciudad::findOrFail($request->ciudad_id);
        $ubicacion->latitud = $request->latitud;
        $ubicacion->longitud = $request->longitud;
        $ubicacion->save();        
        $solicitud->nombre = $request->nombre;   
        $solicitud->fecha_inicio = $request->fecha_inicio;
            $solicitud->estado = "Pendiente";
       

        $solicitud->cliente()->associate($cliente);
        $direccion->barrio = $request->barrio;
        $direccion->direccion = $request->direccion;
        $direccion->ciudad()->associate($ciudad);
        $direccion->ubicacion()->associate($ubicacion);
        $direccion->save();
        $solicitud->direccion()->associate($direccion);
        $solicitud->save();        

       for ($i=0; $i < count($request->cantidad); $i++) { 
        $detalle = new Detalle_solicitud;
        $detalle->nombre = $solicitud->nombre;   
        $detalle->fecha_inicio = $solicitud->fecha_inicio;
        $detalle->estado = $solicitud->estado;
        $detalle->cantidad =  $request->cantidad[$i];
        $detalle->valor_unitario =  $request->valor[$i];
        $detalle->servicio()->associate(Servicio::findOrFail($request->servicio[$i]));
        $detalle->solicitud()->associate($solicitud);
        $detalle->save();  
       }

       Auth::user()->getCliente()->servicios()->detach();

        SweetAlert::success('Exito','La solicitud "'.$solicitud->nombre.'" ha sido registrada.');
        return Redirect::to('home');
    }
    }else{
        abort(403);
                        }
        }

    public function delete_cart_productos($id)
    {  
        if(Auth::user()){
        Auth::user()->authorizeRoles('ROLE_CLIENTE',TRUE);
        $cliente = Auth::user()->getCliente();
        $producto = Producto::findOrFail($id);
        $cliente->productos()->detach($producto);
        return redirect()->back();
    }else{
        abort(403);
                        }
        }

        public function delete_cart_servicios($id)
        {  
            if(Auth::user()){
            Auth::user()->authorizeRoles('ROLE_CLIENTE',TRUE);
            $cliente = Auth::user()->getCliente();
            $servicio = Servicio::findOrFail($id);
            $cliente->servicios()->detach($servicio);
            return redirect()->back();
        }else{
            abort(403);
                            }
            }

    public function add_cart_productos($id)
    {  
        if(Auth::user()){
        Auth::user()->authorizeRoles('ROLE_CLIENTE',TRUE);
        $cliente = Auth::user()->getCliente();
        $producto = Producto::findOrFail($id);
        $cliente->productos()->attach($producto);
        return redirect()->back();
    }else{
        abort(403);
                        }
        }

        public function add_cart_servicios($id)
        {  
            if(Auth::user()){
            Auth::user()->authorizeRoles('ROLE_CLIENTE',TRUE);
            $cliente = Auth::user()->getCliente();
            $servicio = Servicio::findOrFail($id);
            $cliente->servicios()->attach($servicio);
            return redirect()->back();
        }else{
            abort(403);
                            }
            }

    public function cart_productos()
    {
        if(Auth::user()){
            $paises = Pais::orderBy('nombre', 'asc')->get();
        Auth::user()->authorizeRoles('ROLE_CLIENTE',TRUE);
        return View::make('store.productos.cart')->with(compact('paises'));
    }else{
        abort(403);
                        }
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
                if(Auth::user()){
                    $paises = Pais::orderBy('nombre', 'asc')->get();
                    Auth::user()->authorizeRoles('ROLE_CLIENTE',TRUE);
                    return View::make('store.servicios.cart')->with(compact('paises'));
                }else{
abort(403);
                }
               
                }

    
    public function lista_productos(Request $request)
    {
        $productos = producto::select('*'); 
        $expensive = DB::table('productos');
        $categorias = Categoria::all(); 
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

            if(Auth::user() && Auth::user()->authorizeRoles('ROLE_CLIENTE',FALSE)){
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

        return View::make('store.productos.list')->with(compact('productos','categorias','filter'));
    }

    public function lista_servicios(Request $request)
    {
        $servicios = Servicio::select('*'); 
        $expensive = DB::table('servicios');
        $categorias = Categoria::all(); 
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

            if(Auth::user() && Auth::user()->authorizeRoles('ROLE_CLIENTE',FALSE)){
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

        return View::make('store.servicios.list')->with(compact('servicios','categorias','filter'));
    }
}
