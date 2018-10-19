<?php

namespace App\Http\Controllers\Comercio\Marca;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Comercio\Marca;
use Illuminate\Support\Facades\Validator;
Use Alert;

class MarcaController extends Controller
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
        $marcas = Marca::all();
        return View::make('comercio.marcas.index')->with(compact('marcas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR']);
        $marca = new Marca;
        $editar = false;
        return View::make('comercio.marcas.create')->with(compact('marca','editar'));
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
            return Redirect::to('marcas/create')
                ->withErrors($validator);
        } else {
            $marca = new Marca;
            $marca->nombre = $request->nombre; 
           $marca->save();        

            Alert::success('Exito','La marca "'.$marca->nombre.'" ha sido registrada.');
            return Redirect::to('marcas');
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
        $marca = Marca::findOrFail($id);
        return View::make('comercio.marcas.show')->with(compact('marca'));
        
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
        $marca = Marca::findOrFail($id);
        $editar = true;
        return View::make('comercio.marcas.edit')->with(compact('marca','editar'));
   
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
        return Redirect::to('marcas/'+$id+'/edit')
            ->withErrors($validator);
    } else {
        $marca = Marca::findOrFail($request->id);
        $marca->nombre = $request->nombre; 
        $marca->save();
        Alert::success('Exito','La marca "'.$marca->nombre.'" ha sido editada.');
        return Redirect::to('marcas');
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
        $marca = Marca::findOrFail($id);   
        $marca->delete();
        Alert::success('Exito','La marca "'.$marca->nombre.'" ha sido eliminada.');
        return Redirect::to('marcas');
}
}