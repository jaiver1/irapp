<?php

namespace App\Http\Controllers\Dato_basico\Tipo_medida;
use App\Http\Controllers\Controller;
use App\Models\Dato_basico\Tipo_medida;
Use Alert;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Tipo_medidaSoftDeleteController extends Controller
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
    private static function getDeletedTipo_medida($id)
    {
        $tipo_medida = Tipo_medida::onlyTrashed()->where('id', $id)->get();
        
        if (count($tipo_medida) != 1) {
            Alert::error('Error','El tipo de medida no existe.');
            return redirect('/tipos_medidas/deleted');
        }

        return $tipo_medida[0];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR']);
        $tipos_medidas = Tipo_medida::onlyTrashed()->get();
        return View('dato_basico.tipos_medidas.index_deleted', compact('tipos_medidas'));
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
        $tipo_medida = self::getDeletedTipo_medida($id);
        $tipo_medida->restore();
        Alert::success('Exito','El tipo de medida "'.$tipo_medida->nombre.'" ha sido restaurado.');
        return Redirect::to('tipos_medidas/deleted');
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
        $tipo_medida = self::getDeletedTipo_medida($id);
        $tipo_medida->forceDelete();
        Alert::success('Exito','El tipo de medida "'.$tipo_medida->nombre.'" ha sido eliminado permanentemente.');
        return Redirect::to('tipos_medidas/deleted');
    }
}
