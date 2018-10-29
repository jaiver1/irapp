<?php

namespace App\Http\Controllers\Contacto\Cliente;
use App\Http\Controllers\Controller;
use App\Models\Comercio\Producto;
use SweetAlert;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClienteSoftDeleteController extends Controller
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
    private static function getDeletedMarca($id)
    {
        $cliente = Producto::onlyTrashed()->where('id', $id)->get();
        
        if (count($cliente) != 1) {
            SweetAlert::error('Error','El cliente no existe.');
            return redirect('/clientes/deleted');
        }

        return $cliente[0];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR']);
        $clientes = Producto::onlyTrashed()->get();
        return View('contacto.clientes.index_deleted', compact('clientes'));
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
        Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR']);
        $cliente = self::getDeletedMarca($id);
        $cliente->restore();
        SweetAlert::success('Exito','El cliente "'.$cliente->nombre.'" ha sido restaurada.');
        return Redirect::to('clientes/deleted');
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
        Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR']);
        $cliente = self::getDeletedMarca($id);
        $cliente->forceDelete();
        SweetAlert::success('Exito','El cliente "'.$cliente->nombre.'" ha sido eliminado permanentemente.');
        return Redirect::to('clientes/deleted');
    }
}
