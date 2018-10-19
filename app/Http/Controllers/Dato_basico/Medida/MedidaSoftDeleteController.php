<?php

namespace App\Http\Controllers\Dato_basico\Medida;
use App\Http\Controllers\Controller;
use App\Models\Dato_basico\Medida;
Use Alert;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MedidaSoftDeleteController extends Controller
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
    private static function getDeletedMedida($id)
    {
        $medida = Medida::onlyTrashed()->where('id', $id)->get();
        
        if (count($medida) != 1) {
            Alert::error('Error','La medida no existe.');
            return redirect('/medidas/deleted');
        }

        return $medida[0];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR']);
        $medidas = Medida::onlyTrashed()->get();
        return View('dato_basico.medidas.index_deleted', compact('medidas'));
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
        $medida = self::getDeletedMedida($id);
        $medida->restore();
        Alert::success('Exito','La medida "'.$medida->nombre.'" ha sido restaurada.');
        return Redirect::to('medidas/deleted');
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
        $medida = self::getDeletedMedida($id);
        $medida->forceDelete();
        Alert::success('Exito','La medida "'.$medida->nombre.'" ha sido eliminada permanentemente.');
        return Redirect::to('medidas/deleted');
    }
}
