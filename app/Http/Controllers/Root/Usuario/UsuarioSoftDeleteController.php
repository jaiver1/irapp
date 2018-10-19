<?php

namespace App\Http\Controllers\Root\Usuario;
use App\Http\Controllers\Controller;
use App\Models\Root\User;
Use Alert;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsuarioSoftDeleteController extends Controller
{
    protected $redirectTo = '/login';
    
    public function __construct()
    {
     $this->middleware('auth');
    }

    /**
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    private static function getDeletedUsuario($id)
    {
        $usuario = User::onlyTrashed()->where('id', $id)->get();
        
        if (count($usuario) != 1) {
            Alert::error('Error','El usuario no existe.');
            return redirect('/usuarios/deleted');
        }

        return $usuario[0];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    Auth::user()->authorizeRoles(['ROLE_ROOT']);
        $usuarios = User::onlyTrashed()->get();
        return View('root.usuarios.index_deleted', compact('usuarios'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        Auth::user()->authorizeRoles(['ROLE_ROOT']);
        $usuario = self::getDeletedUsuario($id);
        $usuario->restore();
        Alert::success('Exito','El usuario "'.$usuario->name.'" ha sido restaurado.');
        return Redirect::to('usuarios/deleted');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Auth::user()->authorizeRoles(['ROLE_ROOT']);
        $usuario = self::getDeletedUsuario($id);
        $usuario->forceDelete();
        Alert::success('Exito','El usuario "'.$usuario->name.'" ha sido eliminado permanentemente.');
        return Redirect::to('usuarios/deleted');
    }
}
