<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\Clasificacion\Especialidad;
use App\Models\Clasificacion\Categoria;

class StoreController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('store.welcome');
    }

    public function lista_Productos()
    {
        $productos = Categoria::paginate(2); 
        $especialidades = Especialidad::all(); 
        $categoria = new Categoria;
        $categoria->especialidad()->associate(new Especialidad);
        $categoria->categoria()->associate(new Categoria);
        return View::make('store.lista_productos')->with(compact('productos','especialidades','categoria'));
    }
}
