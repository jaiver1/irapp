<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Models\Contacto\Cliente;
use App\Models\Contacto\Persona;
use App\Models\Dato_basico\Ubicacion;
use App\Models\Dato_basico\Direccion;
use App\Models\Dato_basico\Pais;
use App\Models\Dato_basico\Ciudad;
use App\Models\Root\User;
use App\Models\Root\Role;
use SweetAlert;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
 * Show the application registration form.
 *
 * @return \Illuminate\Http\Response
 */
public function showRegistrationForm()
{
    $cliente = new Cliente;
    $persona = new Persona;
    $direccion = new Direccion;
    $direccion->ciudad()->associate(new Ciudad);
    $direccion->ubicacion()->associate(new Ubicacion);
    $persona->usuario()->associate(new User);
    $persona->direccion()->associate($direccion);
    $cliente->persona()->associate($persona);
    $paises = Pais::orderBy('nombre', 'asc')->get();
    return view('auth.register', compact('cliente','paises'));
}

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function register_cliente(Request $request)
    {


        $rules = array(
            'cedula'                   => 'required|max:50|unique:personas',
            'cuenta_banco'                   => 'max:50',
            'primer_nombre'                   => 'required|max:50',
            'segundo_nombre'                   => 'max:50',
            'primer_apellido'                   => 'required|max:50',
            'segundo_apellido'                   => 'max:50',
            'telefono_fijo'                   => 'max:50',
            'telefono_movil'                   => 'required|max:50',
            'barrio'                   => 'required|max:50',
            'direccion'                   => 'required|max:50',
            'latitud'                   => 'required|max:50',
            'longitud'                   => 'required|max:50',
            'ciudad_id'              => 'required',
            'name'                  => 'required|max:50|unique:users',
                'email'                 => 'required|email|max:100|unique:users',
                'password'              => 'required|between:8,50|confirmed',
                'password_confirmation' => 'required|same:password',
                // 'usuario_id'                   => 'required|unique:personas',
    );

        $validator = Validator::make($request->all(), $rules);


        if ($validator->fails()) {
            $request->flash();
            SweetAlert::error('Error','Errores en el formulario.');
            return Redirect::to('register')
                ->withErrors($validator);
        } else {

            $role = Role::findOrFail(4);
            $usuario = new User;
            $usuario->name = $request->name;
            $usuario->email = $request->email;
            $usuario->password =  bcrypt($request->password);         
            $usuario->save();
            $usuario->roles()->attach($role);

            $cliente = new Cliente;
            $persona = new Persona;
            $ubicacion = new Ubicacion;
            $direccion = new Direccion;

            $ubicacion->latitud = $request->latitud;
            $ubicacion->longitud = $request->longitud;
            $ubicacion->save();

            $usuario = User::findOrFail($usuario->id);
            $ciudad = Ciudad::findOrFail($request->ciudad_id);

            $persona->cedula = $request->cedula;
            $persona->cuenta_banco = $request->cuenta_banco;
            $persona->primer_nombre = $request->primer_nombre;
            $persona->segundo_nombre = $request->segundo_nombre;
            $persona->primer_apellido = $request->primer_apellido;
            $persona->segundo_apellido = $request->segundo_apellido;
            $persona->telefono_movil = $request->telefono_movil;
            $persona->telefono_fijo = $request->telefono_fijo;       

            $direccion->barrio = $request->barrio;
            $direccion->direccion = $request->direccion;
            $direccion->ciudad()->associate($ciudad);
            $direccion->ubicacion()->associate($ubicacion);
            $direccion->save();

            $persona->usuario()->associate($usuario);
            $persona->direccion()->associate($direccion);
            $persona->save();

            $cliente->persona()->associate($persona);     
            $cliente->save();        

            SweetAlert::success('Exito','Bienvenido a Irapp.');
            return Redirect::to('login');
        }
    }

}
