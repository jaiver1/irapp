<?php

namespace App\Http\Controllers\Contacto\proveedor;
use App\Http\Controllers\Controller;
use App\Models\Contacto\Proveedor;
use SweetAlert;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProveedorSoftDeleteController extends Controller
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
    private static function getDeletedCliente($id)
    {
        $proveedor = Proveedor::onlyTrashed()->where('id', $id)->get();
        
        if (count($proveedor) != 1) {
            SweetAlert::error('Error','El proveedor no existe.');
            return redirect('/proveedores/deleted');
        }

        return $proveedor[0];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR'],TRUE);
        $proveedores = Proveedor::onlyTrashed()->get();
        return View('contacto.proveedores.index_deleted', compact('proveedores'));
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
        Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR'],TRUE);
        $proveedor = self::getDeletedCliente($id);
        $proveedor->restore();
        SweetAlert::success('Exito','El proveedor "'.$proveedor->persona->primer_nombre." ".$proveedor->persona->primer_apellido.'" ha sido restaurada.');
        return Redirect::to('proveedores/deleted');
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
        Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR'],TRUE);
        $proveedor = self::getDeletedCliente($id);
        $proveedor->forceDelete();
        SweetAlert::success('Exito','El proveedor "'.$proveedor->persona->primer_nombre." ".$proveedor->persona->primer_apellido.'" ha sido eliminado permanentemente.');
        return Redirect::to('proveedores/deleted');
    }
}
