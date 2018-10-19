<?php

namespace App\Http\Controllers\Comercio\Producto;
use App\Http\Controllers\Controller;
use App\Models\Comercio\Producto;
Use Alert;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductoSoftDeleteController extends Controller
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
        $producto = Producto::onlyTrashed()->where('id', $id)->get();
        
        if (count($producto) != 1) {
            Alert::error('Error','El producto no existe.');
            return redirect('/productos/deleted');
        }

        return $producto[0];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR']);
        $productos = Producto::onlyTrashed()->get();
        return View('comercio.productos.index_deleted', compact('productos'));
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
        $producto = self::getDeletedMarca($id);
        $producto->restore();
        Alert::success('Exito','El producto "'.$producto->nombre.'" ha sido restaurada.');
        return Redirect::to('productos/deleted');
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
        $producto = self::getDeletedMarca($id);
        $producto->forceDelete();
        Alert::success('Exito','El producto "'.$producto->nombre.'" ha sido eliminada permanentemente.');
        return Redirect::to('productos/deleted');
    }
}
