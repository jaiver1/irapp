<?php

namespace App\Http\Controllers\Clasificacion\Categoria;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Clasificacion\Categoria;
use App\Models\Clasificacion\Especialidad;
use Illuminate\Support\Facades\Validator;
Use Alert;

class CategoriaController extends Controller
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
        $categorias = Categoria::all();
        return View::make('clasificacion.categorias.index')->with(compact('categorias'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR']);
        $categoria = new Categoria;
        $categoria->especialidad()->associate(new Especialidad);
        $categoria->categoria()->associate(new Categoria);
        $especialidades = Especialidad::all(); 
        $editar = false;
        return View::make('clasificacion.categorias.create')->with(compact('especialidades','categoria','editar'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR']);
        if($request->raiz){
            return Redirect::to('categorias.edit');
        }else{

        }
        $rules = array(
                'nombre'                   => 'required|max:50',
                'categoria_id'                   => 'required',
        );

        $validator = Validator::make($request->all(), $rules);


        if ($validator->fails()) {
            Alert::error('Error','Errores en el formulario.');
            return Redirect::to('categorias/create')
                ->withErrors($validator);
        } else {
            $categoria = new Categoria;
            $categoria->nombre = $request->nombre; 
            $categoria->etiqueta = $request->etiqueta; 
            $categoria->tipo_categoria()->associate(Tipo_categoria::findOrFail($request->tipo_categoria_id));      
            $categoria->save();        

            Alert::success('Exito','La categoria "'.$categoria->nombre.'" ha sido registrada.');
            return Redirect::to('categorias');
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
        $categoria = Categoria::findOrFail($id);
        return View::make('clasificacion.categorias.show')->with(compact('categoria'));
        
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
        $categoria = Categoria::findOrFail($id);
        $especialidades = Especialidad::all(); 
        $editar = false;
        return View::make('clasificacion.categorias.edit')->with(compact('especialidades','categoria','editar'));
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
            'etiqueta'                   => 'required|max:5',
            'tipo_categoria_id'                   => 'required',
    );

    $validator = Validator::make($request->all(), $rules);


    if ($validator->fails()) {
        Alert::error('Error','Errores en el formulario.');
        return Redirect::to('categorias/'+$id+'/edit')
            ->withErrors($validator);
    } else {
        $categoria = Categoria::findOrFail($request->id);
        $categoria->nombre = $request->nombre; 
        $categoria->etiqueta = $request->etiqueta; 
        $categoria->tipo_categoria()->associate(Tipo_categoria::findOrFail($request->tipo_categoria_id)); 
        $categoria->save();

        Alert::success('Exito','La categoria "'.$categoria->nombre.'" ha sido editada.');
        return Redirect::to('categorias');
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
        $categoria = Categoria::findOrFail($id);
    
        $categoria->delete();
        Alert::success('Exito','La categoria "'.$categoria->nombre.'" ha sido eliminada.');
        return Redirect::to('categorias');
}
}