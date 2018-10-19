<?php

namespace App\Http\Controllers\Actividad\Orden;
use App\Http\Controllers\Controller;
use App\Models\Actividad\Orden;
Use Alert;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrdenSoftDeleteController extends Controller
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
    private static function getDeletedOrden($id)
    {
        $orden = Orden::onlyTrashed()->where('id', $id)->get();
        
        if (count($orden) != 1) {
            Alert::error('Error','La orden no existe.');
            return redirect('/ordenes/deleted');
        }

        return $orden[0];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR']);
        $ordenes = Orden::onlyTrashed()->get();
        return View('actividad.ordenes.index_deleted', compact('ordenes'));
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
        $orden = self::getDeletedOrden($id);
        $orden->restore();
        Alert::success('Exito','La orden "'.$orden->nombre.'" ha sido restaurada.');
        return Redirect::to('ordenes/deleted');
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
        $orden = self::getDeletedOrden($id);
        $orden->forceDelete();
        Alert::success('Exito','La orden "'.$orden->nombre.'" ha sido eliminada permanentemente.');
        return Redirect::to('ordenes/deleted');
    }
}
