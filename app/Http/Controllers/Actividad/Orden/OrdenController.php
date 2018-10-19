<?php

namespace App\Http\Controllers\Actividad\Orden;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Actividad\Orden;
use Illuminate\Support\Facades\Validator;
Use Alert;

class OrdenController extends Controller
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
        $ordenes = Orden::all();
        return View::make('actividad.ordenes.index')->with(compact('ordenes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR']);
        $orden = new Orden();
        $editar = false;
        return View::make('actividad.ordenes.create')->with(compact('orden','editar'));
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
            return Redirect::to('ordenes/create')
                ->withErrors($validator);
        } else {
            $orden = new Orden();
            $orden->nombre = $request->nombre; 
           $orden->save();        

            Alert::success('Exito','La orden "'.$orden->nombre.'" ha sido registrada.');
            return Redirect::to('ordenes');
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
        $orden = Orden::findOrFail($id);
        return View::make('actividad.ordenes.show')->with(compact('orden'));
        
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
        $orden = Orden::findOrFail($id);
        $editar = true;
        return View::make('actividad.ordenes.edit')->with(compact('orden','editar'));
   
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
        return Redirect::to('ordenes/'+$id+'/edit')
            ->withErrors($validator);
    } else {
        $orden = Orden::findOrFail($request->id);
        $orden->nombre = $request->nombre; 
        $orden->save();
        Alert::success('Exito','La orden "'.$orden->nombre.'" ha sido editada.');
        return Redirect::to('ordenes');
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
        $orden = Orden::findOrFail($id);   
        $orden->delete();
        Alert::success('Exito','La orden "'.$orden->nombre.'" ha sido eliminada.');
        return Redirect::to('ordenes');
}
}