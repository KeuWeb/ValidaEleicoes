<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\AdmLogin;

class AdmLoginController extends Controller
{
    // Ação para acessar o Sistema (Login)
    public function AdmLoginDo (Request $request)
    {
        if (!isset($request)) {
            return response()->json([
                'status' => "alert",
                'message' => "Ops! Há campo(s) em branco."
            ]);

            exit();
        } else {
            $request->validate([
                'login' => 'required|string',
                'password' => 'required|string'
            ]);

            $login = new AdmLogin();
            
            $login = AdmLogin::where(
                    'login',$request->login
                )->first();
            
            if(!$login){
                return response()->json([
                    'status' => "alert",
                    'message' => "Registro não encontrado."
                ]);

                exit();
            } else {
                if ($login && Hash::check($request->password,$login->password)) {
                    $request->session()->put('id',$login->id);
                    $request->session()->put('name',$login->name);

                    return response()->json([
                        'status' => "success",
                        'message' => "Olá ".$login->name.", redirecionando..."
                    ]);

                    exit();
                } else {
                    return response()->json([
                        'status' => "alert",
                        'message' => "Ops! Senha incorreta."
                    ]);

                    exit();                   
                }
            }
            exit();
        }
    }
}
