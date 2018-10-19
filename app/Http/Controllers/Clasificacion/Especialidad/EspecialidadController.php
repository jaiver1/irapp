<?php
namespace App\Http\Controllers\Clasificacion\Especialidad;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Clasificacion\Especialidad;
use Illuminate\Support\Facades\Validator;
Use Alert;

class EspecialidadController extends Controller
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
        $especialidades = Especialidad::all();
        return View::make('clasificacion.especialidades.index')->with(compact('especialidades'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR']);
        $especialidad = new Especialidad;
        $editar = false;
        return View::make('clasificacion.especialidades.create')->with(compact('especialidad','editar'));
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
            return Redirect::to('especialidades/create')
                ->withErrors($validator);
        } else {
            $especialidad = new Especialidad;
            $especialidad->nombre = $request->nombre; 
            $especialidad->save();        

            Alert::success('Exito','La especialidad "'.$especialidad->nombre.'" ha sido registrada.');
            return Redirect::to('especialidades');
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
        $especialidad = Especialidad::findOrFail($id);
        return View::make('clasificacion.especialidades.show')->with(compact('especialidad'));
        
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
        $especialidad = Especialidad::findOrFail($id);
        $editar = true;
        return View::make('clasificacion.especialidades.edit')->with(compact('especialidad','editar'));
   
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
        return Redirect::to('especialidades/'+$id+'/edit')
            ->withErrors($validator);
    } else {
        $especialidad = Especialidad::findOrFail($request->id);
        $especialidad->nombre = $request->nombre; 
        $especialidad->save();

        Alert::success('Exito','La especialidad "'.$especialidad->nombre.'" ha sido editada.');
        return Redirect::to('especialidades');
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
        $especialidad = Especialidad::findOrFail($id);
    
        $especialidad->delete();
        Alert::success('Exito','La especialidad "'.$especialidad->nombre.'" ha sido eliminada.');
        return Redirect::to('especialidades');
}
}