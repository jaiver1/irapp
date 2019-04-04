<?php

namespace App\Http\Controllers\Comercio\Compra;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Comercio\Compra;
use App\Models\Comercio\Detalle_compra;
use App\Models\Root\User;
use App\Models\Contacto\Cliente;
use App\Models\Contacto\Proveedor;
use App\Models\Contacto\Persona;
use App\Models\Comercio\Producto;
use Illuminate\Support\Facades\Validator;
Use SweetAlert;
Use DB;
use Carbon\Carbon;


class CompraController extends Controller
{
    protected $redirectTo = '/login';
    
    private $teal = '#00897b';
    
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
        Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR'],TRUE);
        
        $compras = Compra::select('*');
        $JSON_compras = Compra::select(DB::raw(
            "compras.id AS id,compras.id AS title,
            REPLACE(compras.fecha,' ','T') AS start,
            '$this->teal' AS color
            ,'fa-calendar-check' AS icon
            ,compras.fecha AS fecha"));

    
        $compras = $compras->get();
        $JSON_compras = $JSON_compras->get();
        $route = 'compras.index';
        return View::make('comercio.compras.index')->with(compact('compras','JSON_compras'));
    }

     /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create($fecha = null)
    {
        Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR'],TRUE);
        $compra = new Compra;
        $compra->fecha = $fecha;
        $editar = false;
       return View::make('comercio.compras.create')->with(compact('compra','editar'));
    }

    public function edit($id)
    {
        Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR'],TRUE);
        $compra = Compra::findOrFail($id);
        $editar = true;
       return View::make('comercio.compras.edit')->with(compact('compra','editar'));
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
            'fecha'                   => 'required|date'
        );

        $validator = Validator::make($request->all(), $rules);


        if ($validator->fails()) {
            SweetAlert::error('Error','Errores en el formulario.');
            return Redirect::to('compras/create')
                ->withErrors($validator);
        } else {
            $compra = new Compra;   
            $compra->fecha = $request->fecha;
           $compra->save();        

            SweetAlert::success('Exito','La compra #'.$compra->id.' ha sido registrada.');
            return Redirect::to('compras/'.$compra->id);
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
        Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR'],TRUE);

        $compra = Compra::findOrFail($id);
        
        return View::make('comercio.compras.show')->with(compact('compra'));
        
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
        'fecha'                   => 'required|date'
    );

    $validator = Validator::make($request->all(), $rules);


    if ($validator->fails()) {
        SweetAlert::error('Error','Errores en el formulario.');
        return Redirect::to('compras/'+$id+'/edit')
            ->withErrors($validator);
    } else { 
        $compra = Compra::findOrFail($id);
        $compra->fecha = $request->fecha;
        $compra->save();
        SweetAlert::success('Exito','La compra #'.$compra->id.' ha sido editada.');
        return Redirect::to('compras');
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
        Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR'],TRUE);
            $compra = Compra::findOrFail($id);
        return View::make('include.comercio.detalles_compras.datatable')->with(compact('compra'));

        }

        public function get_productos($id,$editar)
    {  
        Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR'],TRUE);

            $productos = Producto::whereNotIn('id', function($query) use ($id){
                $query->select('producto_id')->from('detalles_compras')
                ->where('compra_id','=',$id)->distinct();
            })->get();
            $detalle = true;
            $prefix = ($editar) ? "edit_" : "";
        return View::make('include.comercio.productos.modal_search')->with(compact('productos','detalle','prefix'));
       
        }

        public function get_proveedores($id,$editar)
        {  
            Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR'],TRUE);
    
            $proveedores = DB::table('proveedores')
            ->join('personas', 'proveedores.persona_id', '=', 'personas.id')
            ->join('users', 'personas.usuario_id', '=', 'users.id')
            ->join('direcciones', 'personas.direccion_id', '=', 'direcciones.id')
            ->join('ciudades', 'personas.direccion_id', '=', 'ciudades.id')
            ->select('proveedores.id', 'personas.cedula', 'personas.primer_nombre', 'personas.segundo_nombre', 'personas.primer_apellido', 'personas.segundo_apellido'
            , 'personas.telefono_movil', 'personas.telefono_fijo', 'direcciones.barrio', 'direcciones.direccion', 'personas.cuenta_banco'
            , 'ciudades.nombre AS ciudad', 'users.email AS email')
            ->whereIn('proveedores.persona_id',Persona::distinct()->select('id')->whereIn('usuario_id',User::distinct()->select('id')->whereHas('roles', function ($query) {
                $query->where('name', '=', 'ROLE_COLABORADOR');
    })))->whereIn('proveedores.id',DB::table('proveedor_producto')->distinct()
    ->select('proveedor_id')->where('producto_id','=', $id))
    ->get();
    $prefix = ($editar) ? "edit_" : "";
            return View::make('include.contacto.proveedores.modal_search')->with(compact('proveedores','prefix'));
            }

            public function form_detalles($id,$editar)
        {  
            Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR'],TRUE);
    
            if($editar){        
                $detalle = Detalle_compra::findOrFail($id); 
                $compra = Compra::findOrFail($detalle->compra_id);
                $prefix = "edit_";
            }else{
                $compra = Compra::findOrFail($id);
                $detalle = new Detalle_compra; 
                $prefix = "";
            }

            
            return View::make('include.comercio.detalles_compras.form')->with(compact('compra','detalle','editar','prefix'));
            }

            

        public function add_detalles(Request $request)
        {  
            Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR'],TRUE);
            try{
                $rules = array(
                    'valor_unitario'                   => 'numeric|required|digits_between:1,12',
                    'cantidad'                   => 'numeric|required|digits_between:1,12',
                'compra_id'                   => 'required',
                'producto_id'                   => 'required'      
                  );
    
            $validator = Validator::make($request->all(), $rules);
    
    
            if ($validator->fails()) {
                return response()->json(['status'=>500,'message'=>"Error en el formulario",'messageJSON'=>$validator]);
            }else{
                $detalle = new Detalle_compra;
                $compra = Compra::findOrFail($request->compra_id);
                $proveedor = Proveedor::find($request->proveedor_id);
                $producto = Producto::findOrFail($request->producto_id);
                $detalle->valor_unitario = $request->valor_unitario;
                $detalle->cantidad = $request->cantidad;
                $detalle->compra()->associate($compra);
                $detalle->proveedor()->associate($proveedor);
                $detalle->producto()->associate($producto);
                $detalle->save();

                $producto->stock += $detalle->cantidad;
                $producto->save();
                return response()->json(['status'=>200,'message'=>'El detalle #'.$detalle->id.' ha sido registrado.']);
               
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
                            'edit_valor_unitario'                   => 'numeric|required|digits_between:1,12',
                            'edit_cantidad'                   => 'numeric|required|digits_between:1,12',
                        'edit_producto_id'                   => 'required'      
                          );
            
                    $validator = Validator::make($request->all(), $rules);
            
            
                    if ($validator->fails()) {
                        return response()->json(['status'=>500,'message'=>"Error en el formulario",'messageJSON'=>$validator]);
                    }else{
                        $detalle = Detalle_compra::findOrFail($id);
                        $proveedor = Proveedor::find($request->edit_proveedor_id);
                        $producto = Producto::findOrFail($request->edit_producto_id);
                        $detalle->valor_unitario = $request->edit_valor_unitario;
                        $detalle->cantidad = $request->edit_cantidad;                       
                        $detalle->proveedor()->associate($proveedor);
                        $detalle->producto()->associate($producto);
                        $detalle->save();
                        return response()->json(['status'=>200,'message'=>'El detalle #'.$detalle->id.' ha sido editado.']);
                       
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
                    $detalle = Detalle_compra::findOrFail($request->detalle);
                    $compra = Proveedor::findOrFail($detalle->id_compra);
                    $compra->detalles()->detach($detalle);
                    return response()->json(['status'=>200,'message'=>'El detalle #'.$detalle->id.' ha sido eliminado.']);
                   
            }
    
            } catch (Throwable $e) {
                return response()->json(['status'=>500,'message'=>$e->getMessage()]);
            } 
                }

}