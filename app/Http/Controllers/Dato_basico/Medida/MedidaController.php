<?php

namespace App\Http\Controllers\Dato_basico\Medida;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Dato_basico\Medida;
use App\Models\Dato_basico\Tipo_medida;
use Illuminate\Support\Facades\Validator;
Use Alert;

class MedidaController extends Controller
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
        $medidas = Medida::all();
        return View::make('dato_basico.medidas.index')->with(compact('medidas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR']);
        $medida = new Medida;
        $tipos_medidas = Tipo_medida::all();
        $editar = false;
        return View::make('dato_basico.medidas.create')->with(compact('tipos_medidas','medida','editar'));
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
                'etiqueta'                   => 'required|max:5',
                'tipo_medida_id'                   => 'required',
        );

        $validator = Validator::make($request->all(), $rules);


        if ($validator->fails()) {
            Alert::error('Error','Errores en el formulario.');
            return Redirect::to('medidas/create')
                ->withErrors($validator);
        } else {
            $medida = new Medida;
            $medida->nombre = $request->nombre; 
            $medida->etiqueta = $request->etiqueta; 
            $medida->tipo_medida()->associate(Tipo_medida::findOrFail($request->tipo_medida_id));      
            $medida->save();        

            Alert::success('Exito','La medida "'.$medida->nombre.'" ha sido registrada.');
            return Redirect::to('medidas');
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
        $medida = Medida::findOrFail($id);
        return View::make('dato_basico.medidas.show')->with(compact('medida'));
        
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
        $medida = Medida::findOrFail($id);
        $tipos_medidas = Tipo_medida::all();
        $editar = true;
        return View::make('dato_basico.medidas.edit')->with(compact('tipos_medidas','medida','editar'));
   
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
            'tipo_medida_id'                   => 'required',
    );

    $validator = Validator::make($request->all(), $rules);


    if ($validator->fails()) {
        Alert::error('Error','Errores en el formulario.');
        return Redirect::to('medidas/'+$id+'/edit')
            ->withErrors($validator);
    } else {
        $medida = Medida::findOrFail($request->id);
        $medida->nombre = $request->nombre; 
        $medida->etiqueta = $request->etiqueta; 
        $medida->tipo_medida()->associate(Tipo_medida::findOrFail($request->tipo_medida_id)); 
        $medida->save();

        Alert::success('Exito','La medida "'.$medida->nombre.'" ha sido editada.');
        return Redirect::to('medidas');
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
        $medida = Medida::findOrFail($id);
    
        $medida->delete();
        Alert::success('Exito','La medida "'.$medida->nombre.'" ha sido eliminada.');
        return Redirect::to('medidas');
}
}