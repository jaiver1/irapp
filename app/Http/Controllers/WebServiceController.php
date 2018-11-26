<?php

namespace App\Http\Controllers;

use App\Models\Actividad\Orden;
use App\Models\Root\User;
use Hash;
use Blocktrail\CryptoJSAES\CryptoJSAES;

class WebServiceController extends Controller
{
   
    private $key = "LzlDiqCCvXJUQ8j3+CWh1LgMfPMiLuVfIOElqaZ0Zg0=";  
    public function __construct()
    {
      
    }

    public function login($email_aes,$password_aes)
    {
        $result = array('status' => 500, 'message' => "Hubo un error", 'response' => NULL);
        try{    
            $email = CryptoJSAES::decrypt(base64_decode($email_aes),$this->key);
            $password = CryptoJSAES::decrypt(base64_decode($password_aes),$this->key);          
            $user = User::whereHas('roles', function ($query) {
                $query->where('name', '=', 'ROLE_ROOT');
     })->where('email','=',$email)->first();
            if($user != null){
                if(Hash::check($password,$user->password)) {
                    $result[0] = 200;
                    $result[1] = "Bienvenido usuario ". $user->name;
                    $result[2] = $user;
                }
            }     
            return response()->json($result);
        }catch(Exception $error){
            $result[1] = $error->getMessage();
            return response()->json($result);
        }   
    }

     public function ordenes()
    {
        $result = array('status' => 500, 'message' => "Hubo un error", 'response' => NULL);
        try{    
            $user_id = CryptoJSAES::decrypt(base64_decode($id_aes),$this->key);
            $cliente = Cliente::where('email','=',$user_id)->first();
            $ordenes = Orden::all(); 
            $result[0] = 200;
                    $result[1] = "Bienvenido usuario ". $user->name;
                    $result[2] = $ordenes;  
            return response()->json($result);
        }catch(Exception $error){
            $result[1] = $error->getMessage();
            return response()->json($result);
        }   
    }

}
