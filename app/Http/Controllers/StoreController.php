<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\Clasificacion\Especialidad;
use App\Models\Clasificacion\Categoria;
use App\Models\Comercio\Marca;
use App\Models\Comercio\Producto;

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
        $productos = Producto::paginate(2); 
        $especialidades = Especialidad::all(); 
        $marcas = Marca::all(); 
        $categoria_actual = new Categoria;
        $marca_actual = new Marca;

        return View::make('store.lista_productos')->with(compact('productos','especialidades','marcas','categoria_actual','marca_actual'));
    }
}
