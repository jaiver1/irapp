<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
     protected $redirectTo = '/login';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR','ROLE_COLABORADOR'],TRUE);
        return view('home.index');
    }

    public function upload_imagenes($id,Request $request)
    {  
        Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR'],TRUE);
        try{
            $rules = array(
                'imagen'                   => 'required|mimes:jpeg,png|max:2000',
                'url_imagenes'                   => 'url|required'          
              );

        $validator = Validator::make($request->all(), $rules);


        if ($validator->fails()) {
            return response()->json(['status'=>500,'message'=>$validator]);
        }else{
        if ($request->hasFile('imagen') && $request->file('imagen')->isValid()) {                
            $image = $request->file('imagen');
            $producto = Producto::findOrFail($id);
            $filename = $producto->id.'-'.$image->getClientOriginalName(); 
            $dir = 'img/dashboard/productos/imagenes';
            $public_dir = public_path($dir);
            
            $route =  $dir.'/'. $filename;
            if (!file_exists($public_dir)) {
                mkdir($public_dir, 0777);
            } 
            $path = public_path($route);          
                Image::make($image->getRealPath())->save($path);
                $imagen_producto = new Imagen_producto;
                $imagen_producto->nombre = $filename;
                $imagen_producto->ruta = $route;
                $imagen_producto->producto()->associate($producto);      
                $imagen_producto->save();
               return response()->json(['status'=>200,'message'=>'OK']);
           }else{ 
            return response()->json(['status'=>500,'message'=>'Error al subir la imagen.']);
        }
    }

    } catch (Throwable $e) {
        return response()->json(['status'=>500,'message'=>$e->getMessage()]);
    } catch (Exception $e) {
        return response()->json(['status'=>500,'message'=>$e->getMessage()]);
    }
        }
}
