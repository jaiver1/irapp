<?php

namespace App\Http\Controllers\Contacto\Cliente;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Contacto\Cliente;
use App\Models\Contacto\Persona;
use App\Models\Dato_basico\XUbicacion;
use Illuminate\Support\Facades\Validator;
use SweetAlert;

class ClienteController extends Controller
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
        $clientes = Cliente::all();
        return View::make('contacto.clientes.index')->with(compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR']);
        $cliente = new Cliente;
        $persona = new Persona;
        $persona->ubicacion()->associate(new XUbicacion);
        $cliente->persona()->associate($persona);
        $editar = false;
        return View::make('contacto.clientes.create')->with(compact('cliente','editar'));
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
            $request->flash();
            SweetAlert::error('Error','Errores en el formulario.');
            return Redirect::to('clientes/create')
                ->withErrors($validator);
        } else {
            $cliente = new Cliente;
            $cliente->nombre = $request->nombre;      
            $cliente->save();        

            SweetAlert::success('Exito','El tipo de medida "'.$cliente->nombre.'" ha sido registrado.');
            return Redirect::to('clientes');
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
        $cliente = Cliente::findOrFail($id);
        return View::make('contacto.clientes.show')->with(compact('cliente'));
        
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
        $cliente = Cliente::findOrFail($id);
        $editar = true;
        return View::make('contacto.clientes.edit')->with(compact('cliente','editar'));
   
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
        $request->flash();
        SweetAlert::error('Error','Errores en el formulario.');
        return Redirect::to('clientes/'+$id+'/edit')
            ->withErrors($validator);
    } else {
        $cliente =  Cliente::findOrFail($request->id);
        $cliente->nombre = $request->nombre;        
        $cliente->save();

        SweetAlert::success('Exito','El tipo de medida "'.$cliente->nombre.'" ha sido editado.');
        return Redirect::to('clientes');
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
        $cliente = Cliente::findOrFail($id);
    
        $cliente->delete();
        SweetAlert::success('Exito','El tipo de medida "'.$cliente->nombre.'" ha sido eliminado.');
        return Redirect::to('clientes');
}
}