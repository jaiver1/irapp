<?php

namespace App\Http\Controllers\Dato_basico\Tipo_medida;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Dato_basico\Tipo_medida;
use Illuminate\Support\Facades\Validator;
Use Alert;

class Tipo_medidaController extends Controller
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
        $tipos_medidas = Tipo_medida::all();
        return View::make('dato_basico.tipos_medidas.index')->with(compact('tipos_medidas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR']);
        $tipo_medida = new Tipo_medida;
        $editar = false;
        return View::make('dato_basico.tipos_medidas.create')->with(compact('tipo_medida','editar'));
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
                'nombre'  => 'required|max:50',
        );

        $validator = Validator::make($request->all(), $rules);


        if ($validator->fails()) {
            Alert::error('Error','Errores en el formulario.');
            return Redirect::to('tipos_medidas/create')
                ->withErrors($validator);
        } else {
            $tipo_medida = new Tipo_medida;
            $tipo_medida->nombre = $request->nombre;      
            $tipo_medida->save();        

            Alert::success('Exito','El tipo de medida "'.$tipo_medida->nombre.'" ha sido registrado.');
            return Redirect::to('tipos_medidas');
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
        $tipo_medida = Tipo_medida::findOrFail($id);
        return View::make('dato_basico.tipos_medidas.show')->with(compact('tipo_medida'));
        
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
        $tipo_medida = Tipo_medida::findOrFail($id);
        $editar = true;
        return View::make('dato_basico.tipos_medidas.edit')->with(compact('tipo_medida','editar'));
   
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
            'nombre' => 'required|max:50',
    );

    $validator = Validator::make($request->all(), $rules);


    if ($validator->fails()) {
        Alert::error('Error','Errores en el formulario.');
        return Redirect::to('tipos_medidas/'+$id+'/edit')
            ->withErrors($validator);
    } else {
        $tipo_medida =  Tipo_medida::findOrFail($request->id);
        $tipo_medida->nombre = $request->nombre;        
        $tipo_medida->save();

        Alert::success('Exito','El tipo de medida "'.$tipo_medida->nombre.'" ha sido editado.');
        return Redirect::to('tipos_medidas');
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
        $tipo_medida = Tipo_medida::findOrFail($id);
    
        $tipo_medida->delete();
        Alert::success('Exito','El tipo de medida "'.$tipo_medida->nombre.'" ha sido eliminado.');
        return Redirect::to('tipos_medidas');
}
}