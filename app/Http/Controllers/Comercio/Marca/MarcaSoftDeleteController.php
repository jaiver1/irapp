<?php

namespace App\Http\Controllers\Comercio\Marca;
use App\Http\Controllers\Controller;
use App\Models\Comercio\Marca;
Use Alert;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MarcaSoftDeleteController extends Controller
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
        $marca = Marca::onlyTrashed()->where('id', $id)->get();
        
        if (count($marca) != 1) {
            Alert::error('Error','La marca no existe.');
            return redirect('/marcas/deleted');
        }

        return $marca[0];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR']);
        $marcas = Marca::onlyTrashed()->get();
        return View('comercio.marcas.index_deleted', compact('marcas'));
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
        $marca = self::getDeletedMarca($id);
        $marca->restore();
        Alert::success('Exito','La marca "'.$marca->nombre.'" ha sido restaurada.');
        return Redirect::to('marcas/deleted');
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
        $marca = self::getDeletedMarca($id);
        $marca->forceDelete();
        Alert::success('Exito','La marca "'.$marca->nombre.'" ha sido eliminada permanentemente.');
        return Redirect::to('marcas/deleted');
    }
}
