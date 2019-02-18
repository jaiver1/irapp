<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManagerStatic as Image;
use App\Models\Root\User;

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

    public function upload_imagen($id,Request $request)
    {  
        Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR'],TRUE);
        try{
            $rules = array(
                'imagen'                   => 'required|mimes:jpeg,png|max:2000',          
              );

        $validator = Validator::make($request->all(), $rules);


        if ($validator->fails()) {
            return response()->json(['status'=>500,'message'=>"Archivo no válido",'style'=>"badge-danger",'messageJSON'=>$validator]);
        }else{
        if ($request->hasFile('imagen') && $request->file('imagen')->isValid()) {                
            $image = $request->file('imagen');
            $usuario = User::find($id);
            if($usuario){
            $filename = $usuario->id.'-'.$image->getClientOriginalName(); 
            $dir = 'img/dashboard/usuarios/imagenes';
            $public_dir = public_path($dir);
            
            $route =  $dir.'/'. $filename;
            if (!file_exists($public_dir)) {
                mkdir($public_dir, 0777);
            } 
            $path = public_path($route);          
                Image::make($image->getRealPath())->save($path);
                $usuario->imagen = $route;    
                $usuario->save();
               return response()->json(['status'=>200,'url_img'=>asset($usuario->imagen),'message'=>'Imagen actualizada','style'=>"badge-success"]);
            }else{ 
                return response()->json(['status'=>500,'message'=>'Usuario no encontrado','style'=>"badge-warning"]);
            }
            
           }else{ 
            return response()->json(['status'=>500,'message'=>'Error al subir','style'=>"badge-danger"]);
        }
    }

    } catch (Throwable $e) {
        return response()->json(['status'=>500,'message'=>$e->getMessage(),'style'=>"badge-danger"]);
    } catch (Exception $e) {
        return response()->json(['status'=>500,'message'=>$e->getMessage(),'style'=>"badge-danger"]);
    }
        }
}
