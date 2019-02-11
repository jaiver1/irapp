<?php

namespace App\Http\Controllers\Actividad\Servicio;
use App\Http\Controllers\Controller;
use App\Models\Actividad\Servicio;
Use SweetAlert;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServicioSoftDeleteController extends Controller
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
    private static function getDeletedServicio($id)
    {
        $servicio = Servicio::onlyTrashed()->where('id', $id)->get();
        
        if (count($servicio) != 1) {
            SweetAlert::error('Error','El servicio no existe.');
            return redirect('/servicios/deleted');
        }

        return $servicio[0];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR'],TRUE);
        $servicios = Servicio::onlyTrashed()->get();
        return View('actividad.servicios.index_deleted', compact('servicios'));
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
        $servicio = self::getDeletedServicio($id);
        $servicio->restore();
        SweetAlert::success('Exito','El servicio "'.$servicio->nombre.'" ha sido restaurado.');
        return Redirect::to('servicios/deleted');
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
        $servicio = self::getDeletedServicio($id);
        $servicio->forceDelete();
        SweetAlert::success('Exito','El servicio "'.$servicio->nombre.'" ha sido eliminado permanentemente.');
        return Redirect::to('servicios/deleted');
    }
}
