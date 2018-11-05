<?php

namespace App\Http\Controllers\Comercio\Producto;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Comercio\Producto;
use App\Models\Comercio\XImagen_producto;
use App\Models\Comercio\Marca;
use App\Models\Clasificacion\Especialidad;
use App\Models\Clasificacion\Categoria;
use App\Models\Dato_basico\Medida;
use App\Models\Dato_basico\Tipo_medida;
use App\Models\Dato_basico\XTipo_referencia;
use Illuminate\Support\Facades\Validator;
use SweetAlert;
use DNS1D;
use DNS2D;
use Exception;
use Throwable;
use Intervention\Image\ImageManagerStatic as Image;

class ProductoController extends Controller
{
    protected $redirectTo = '/login';
    
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
        $productos = Producto::all();
        return View::make('comercio.productos.index')->with(compact('productos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR']);
        $producto = new Producto; 
        $producto->medida()->associate(new Medida);
        $producto->categoria()->associate(new Categoria);
        $producto->marca()->associate(new Marca);
        $producto->tipo_referencia()->associate(new XTipo_referencia);
        
        $tipos_medidas = Tipo_medida::all();
        $especialidades = Especialidad::all();   
        $marcas = Marca::all(); 
        $grupos = array();
        $editar = false;
        return View::make('comercio.productos.create')->with(compact('producto','editar','tipos_medidas','especialidades','marcas','grupos'));
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
                'valor_unitario'                   => 'numeric|required|digits_between:1,12',
                'referencia'                   => 'required|max:50',
                'medida_id'                   => 'required',
                'marca_id'                   => 'required',
                'categoria_id'                   => 'required',
                'tipo_referencia_id'            => 'required',
                'descripcion'                => 'required|max:1000'
        );

        $validator = Validator::make($request->all(), $rules);


        if ($validator->fails()) {
            $request->flash();
            SweetAlert::error('Error','Errores en el formulario.');
            return Redirect::to('productos/create')
                ->withErrors($validator);
        } else {
            $producto = new Producto;
            $producto->nombre = $request->nombre; 
            $producto->referencia = $request->referencia; 
            $producto->valor_unitario = $request->valor_unitario; 
            $producto->descripcion = $request->descripcion; 
            $producto->categoria()->associate(Categoria::findOrFail($request->categoria_id));      
            $producto->medida()->associate(Medida::findOrFail($request->medida_id));      
            $producto->marca()->associate(Marca::findOrFail($request->marca_id));      
            $producto->tipo_referencia()->associate(XTipo_referencia::findOrFail($request->tipo_referencia_id));  
            $producto->create();        

            SweetAlert::success('Exito','El producto "'.$producto->nombre.'" ha sido registrada.');
            return Redirect::to('productos/'.$producto->id);
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
        $producto = Producto::findOrFail($id);
        $grupos = $this->search_referencias($producto->referencia);
        $tipos_referencias = array_merge($grupos[0][1],$grupos[1][1]);
        return View::make('comercio.productos.show')->with(compact('producto','tipos_referencias'));
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
        $producto = Producto::findOrFail($id);
        $editar = true;
        $tipos_medidas = Tipo_medida::all();
        $especialidades = Especialidad::all();   
        $marcas = Marca::all(); 
        $grupos = $this->search_referencias($producto->referencia);
        return View::make('comercio.productos.edit')->with(compact('producto','editar','tipos_medidas','especialidades','marcas','grupos'));
   
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
            'valor_unitario'                   => 'numeric|required|digits_between:1,12',
            'referencia'                   => 'required|max:50',
            'medida_id'                   => 'required',
            'marca_id'                   => 'required',
            'categoria_id'                   => 'required',
            'tipo_referencia_id'            => 'required',
            'descripcion'                => 'required|max:1000'
    );
    $validator = Validator::make($request->all(), $rules);


    if ($validator->fails()) {
        $request->flash();
        SweetAlert::error('Error','Errores en el formulario.');
        return Redirect::to('productos/'.$id.'/edit')
            ->withErrors($validator);
    } else {
        $producto = Producto::findOrFail($request->id);
        $producto->nombre = $request->nombre; 
        $producto->referencia = $request->referencia; 
        $producto->valor_unitario = $request->valor_unitario; 
        $producto->descripcion = $request->descripcion; 
        $producto->categoria()->associate(Categoria::findOrFail($request->categoria_id));      
        $producto->medida()->associate(Medida::findOrFail($request->medida_id));      
        $producto->marca()->associate(Marca::findOrFail($request->marca_id));      
        $producto->tipo_referencia()->associate(XTipo_referencia::findOrFail($request->tipo_referencia_id));  
       $producto->save(); 
      
        SweetAlert::success('Exito','El producto "'.$producto->nombre.'" ha sido editada.');
        return Redirect::to('productos');
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
        $producto = Producto::findOrFail($id);   
        $producto->delete();
        SweetAlert::success('Exito','El producto "'.$producto->nombre.'" ha sido eliminada.');
        return Redirect::to('productos');
}

 /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function load_referencias($id)
    { 
        Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR']);
        $producto = Producto::findOrFail($id);
        return View::make('include.comercio.productos.modal_ref')->with(compact('producto'));
        
        }

         /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function load_imagenes($id)
    {  
        Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR']);
        $producto = Producto::findOrFail($id);
        return View::make('include.comercio.productos.modal_img')->with(compact('producto'));
        
        }

            /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function load_row_imagenes($id)
    {  
        Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR']);
        $producto = Producto::findOrFail($id);
        return View::make('include.comercio.productos.div_row_img')->with(compact('producto'));
        
        }

        public function upload_imagenes($id,Request $request)
        {  
            Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR']);
            try{
                $rules = array(
                    'imagen'                   => 'required|mimes:jpeg,png|max:2000',
                    'url_imagenes'                   => 'url|required'          
                  );
    
            $validator = Validator::make($request->all(), $rules);
    
    
            if ($validator->fails()) {
                return response()->json(['status'=>500,'message'=>$validator]);
            }else{
            if ($request->hasFile('imagen') && $request->file('imagen')->isValid()) {                
                $image = $request->file('imagen');
                $producto = Producto::findOrFail($id);
                $filename = $producto->id.'-'.$image->getClientOriginalName();  
                $route = 'img/dashboard/productos/imagenes/' . $filename;
                $path = public_path($route);          
                    Image::make($image->getRealPath())->save($path);
                    $imagen_producto = new XImagen_producto;
                    $imagen_producto->nombre = $filename;
                    $imagen_producto->ruta = $route;
                    $imagen_producto->producto()->associate($producto);      
                    $imagen_producto->save();
                   return response()->json(['status'=>200,'message'=>'OK']);
               }else{ 
                return response()->json(['status'=>500,'message'=>'Error al subir']);
            }
        }

        } catch (Throwable $e) {
            return response()->json(['status'=>500,'message'=>$e]);
        } catch (Exception $e) {
            return response()->json(['status'=>500,'message'=>$e]);
        }
            }

         /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function test_referencias(Request $request)
    {  
        Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR']);
        return response()->json($this->search_referencias($request->content));    
        }

        public function search_referencias($content)
        { 
            $referencias_1d = array();
            $referencias_2d = array();
           
            if(is_numeric($content[0])){
            foreach (XTipo_referencia::where('dimension' , '=', '1D')->get() as $key => $tipo_referencia) {
                try{
                    DNS1D::getBarcodePNG($content, $tipo_referencia->nombre);
                    $referencias_1d[] = $tipo_referencia;
      } catch (Throwable $e) {
      } catch (Exception $e) {
      }
            }

            foreach (XTipo_referencia::where('dimension' , '=', '2D')->get() as $key => $tipo_referencia) {
                try{
                        DNS2D::getBarcodePNG($content, $tipo_referencia->nombre);
                        $referencias_2d[] = $tipo_referencia;
      } catch (Throwable $e) {
      } catch (Exception $e) {
      }
            }
        }
           
            return array(
                array('1D',$referencias_1d),
                array('2D',$referencias_2d));
        }


          /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function delete_imagenes($id)
    {
        try{
        Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR']);
        $imagen = XImagen_producto::findOrFail($id);   

        $imagen->delete();
        unlink($imagen->ruta);
        return response()->json(['status'=>200,'message'=>"OK"]);

    } catch (Throwable $e) {
        return response()->json(['status'=>500,'message'=>$e]);
    } catch (Exception $e) {
        return response()->json(['status'=>500,'message'=>$e]);
    }
}
}