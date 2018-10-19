<?php

namespace App\Http\Controllers\Comercio\Producto;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Comercio\Producto;
use App\Models\Comercio\Marca;
use App\Models\Clasificacion\Especialidad;
use App\Models\Clasificacion\Categoria;
use App\Models\Dato_basico\Medida;
use App\Models\Dato_basico\Tipo_medida;
use App\Models\Dato_basico\X_Tipo_referencia;
use Illuminate\Support\Facades\Validator;
Use Alert;

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
        $producto->tipo_referencia()->associate(new X_Tipo_referencia);
        
        $tipos_medidas = Tipo_medida::all();
        $especialidades = Especialidad::all();   
        $marcas = Marca::all(); 
        $grupos = array(array('1D',
        X_Tipo_referencia::where('dimension' , '=', '1D')->get()),
        array('2D',
        X_Tipo_referencia::where('dimension' , '=', '2D')->get()),
    );
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
                'nombre'                   => 'required|max:50'
        );

        $validator = Validator::make($request->all(), $rules);


        if ($validator->fails()) {
            Alert::error('Error','Errores en el formulario.');
            return Redirect::to('productos/create')
                ->withErrors($validator);
        } else {
            $producto = new Producto;
            $producto->nombre = $request->nombre; 
           $producto->save();        

            Alert::success('Exito','El producto "'.$producto->nombre.'" ha sido registrada.');
            return Redirect::to('productos');
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
        return View::make('comercio.productos.show')->with(compact('producto'));
        
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
        return View::make('comercio.productos.edit')->with(compact('producto','editar'));
   
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
            'nombre'                   => 'required|max:50'
    );

    $validator = Validator::make($request->all(), $rules);


    if ($validator->fails()) {
        Alert::error('Error','Errores en el formulario.');
        return Redirect::to('productos/'+$id+'/edit')
            ->withErrors($validator);
    } else {
        $producto = Producto::findOrFail($request->id);
        $producto->nombre = $request->nombre; 
        $producto->save();
        Alert::success('Exito','El producto "'.$producto->nombre.'" ha sido editada.');
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
        Alert::success('Exito','El producto "'.$producto->nombre.'" ha sido eliminada.');
        return Redirect::to('productos');
}
}