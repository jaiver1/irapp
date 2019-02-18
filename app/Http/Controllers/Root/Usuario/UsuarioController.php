<?php

namespace App\Http\Controllers\Root\Usuario;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Root\User;
use App\Models\Root\Role;
use Illuminate\Support\Facades\Validator;
use SweetAlert;

class UsuarioController extends Controller
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
        Auth::user()->authorizeRoles('ROLE_ROOT',TRUE);
        $usuarios = User::all();
        return View::make('root.usuarios.index')->with(compact('usuarios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        Auth::user()->authorizeRoles('ROLE_ROOT',TRUE);
        $usuario = new User;
        $roles = Role::limit(2)->get();
        $editar = false;
        return View::make('root.usuarios.create')->with(compact('usuario','roles','editar'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        Auth::user()->authorizeRoles('ROLE_ROOT',TRUE);
        $rules = array(
                'name'                  => 'required|max:50|unique:users',
                'email'                 => 'required|email|max:100|unique:users',
                'password'              => 'required|between:6,50|confirmed',
                'password_confirmation' => 'required|same:password',
                'role_id'                   => 'required',
        );

        $validator = Validator::make($request->all(), $rules);


        if ($validator->fails()) {
            $request->flash();
            SweetAlert::error('Error','Errores en el formulario.');
            return Redirect::to('usuarios/create')
                ->withErrors($validator);
        } else {
            $role = Role::findOrFail($request->role_id);
            $usuario = new User;
            $usuario->name = $request->name;
            $usuario->email = $request->email;
            $usuario->password =  bcrypt($request->password);         
            $usuario->save();
            $usuario->roles()->attach($role);

            SweetAlert::success('Exito','El usuario "'.$usuario->name.'" ha sido registrado.');
            return Redirect::to('usuarios');
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
        Auth::user()->authorizeRoles('ROLE_ROOT',TRUE);
        $usuario = User::findOrFail($id);
        return View::make('root.usuarios.show')->with(compact('usuario'));
        
        }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        Auth::user()->authorizeRoles('ROLE_ROOT',TRUE);
        $usuario = User::findOrFail($id);
        $roles = Role::limit(2)->get();
        $editar = true;
        $default_role = NULL;
        if($usuario->roles()->count() > 0){
            $first_role = $usuario->roles()->first();
            if($first_role->id > 2){
                $default_role = $first_role;
            }
        }
        
        return View::make('root.usuarios.edit')->with(compact('usuario','roles','editar','default_role'));
   
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id,Request $request)
    {
        Auth::user()->authorizeRoles('ROLE_ROOT',TRUE);
        $rules = array(
            'name'                  => 'required|max:50|unique:users',
            'email'                 => 'required|email|max:100|unique:users',
            'password'              => 'required|between:6,50|confirmed',
            'password_confirmation' => 'required|same:password',
            'role_id'                   => 'required',
    );

    $validator = Validator::make($request->all(), $rules);


    if ($validator->fails()) {
        $request->flash();
        SweetAlert::error('Error','Errores en el formulario.');
        return Redirect::to('usuarios/'+$id+'/edit')
            ->withErrors($validator);
    } else {
        $role = Role::findOrFail($request->role_id);
        $usuario =  User::findOrFail($id);
        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->password =  bcrypt($request->password);         
        $usuario->save();
        $usuario->roles()->attach($role);

        SweetAlert::success('Exito','El usuario "'.$usuario->name.'" ha sido editado.');
        return Redirect::to('usuarios');
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
        Auth::user()->authorizeRoles('ROLE_ROOT',TRUE);
        $usuario = User::findOrFail($id);
    
        $usuario->delete();
        SweetAlert::success('Exito','El usuario "'.$usuario->name.'" ha sido eliminado.');
        return Redirect::to('usuarios');
}
}