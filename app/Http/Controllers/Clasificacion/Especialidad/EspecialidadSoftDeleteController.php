<?php

namespace App\Http\Controllers\Clasificacion\Especialidad;
use App\Http\Controllers\Controller;
use App\Models\Clasificacion\Especialidad;
Use Alert;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EspecialidadSoftDeleteController extends Controller
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
    private static function getDeletedEspecialidad($id)
    {
        $especialidad = Especialidad::onlyTrashed()->where('id', $id)->get();
        
        if (count($especialidad) != 1) {
            Alert::error('Error','La especialidad no existe.');
            return redirect('/especialidades/deleted');
        }

        return $especialidad[0];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR']);
        $especialidades = Especialidad::onlyTrashed()->get();
        return View('clasificacion.especialidades.index_deleted', compact('especialidades'));
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
        $especialidad = self::getDeletedEspecialidad($id);
        $especialidad->restore();
        Alert::success('Exito','La especialidad "'.$especialidad->nombre.'" ha sido restaurada.');
        return Redirect::to('especialidades/deleted');
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
        $especialidad = self::getDeletedEspecialidad($id);
        $especialidad->forceDelete();
        Alert::success('Exito','La especialidad "'.$especialidad->nombre.'" ha sido eliminada permanentemente.');
        return Redirect::to('especialidades/deleted');
    }
}
