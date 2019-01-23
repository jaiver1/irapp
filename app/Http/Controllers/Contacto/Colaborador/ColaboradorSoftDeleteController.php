<?php

namespace App\Http\Controllers\Contacto\colaborador;
use App\Http\Controllers\Controller;
use App\Models\Contacto\colaborador;
use SweetAlert;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ColaboradorSoftDeleteController extends Controller
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
        $colaborador = colaborador::onlyTrashed()->where('id', $id)->get();
        
        if (count($colaborador) != 1) {
            SweetAlert::error('Error','El colaborador no existe.');
            return redirect('/colaboradores/deleted');
        }

        return $colaborador[0];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR']);
        $colaboradores = colaborador::onlyTrashed()->get();
        return View('contacto.colaboradores.index_deleted', compact('colaboradores'));
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
        $colaborador = self::getDeletedCliente($id);
        $colaborador->restore();
        SweetAlert::success('Exito','El colaborador "'.$colaborador->persona->primer_nombre." ".$colaborador->persona->primer_apellido.'" ha sido restaurada.');
        return Redirect::to('colaboradores/deleted');
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
        $colaborador = self::getDeletedCliente($id);
        $colaborador->forceDelete();
        SweetAlert::success('Exito','El colaborador "'.$colaborador->persona->primer_nombre." ".$colaborador->persona->primer_apellido.'" ha sido eliminado permanentemente.');
        return Redirect::to('colaboradores/deleted');
    }
}
