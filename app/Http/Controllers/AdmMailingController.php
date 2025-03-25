<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\AdmMailing;

class AdmMailingController extends Controller
{
    // Ação para acessar a pagina e seu formulário
    public function AdmMailing()
    {
        return view('adm/mailing');
    }
    // Ação para salvar os dados no BD
    public function AdmMailingDo(Request $request)
    {
        if (!isset($request)) {
            return response()->json([
                'status' => "alert",
                'message' => "Ops! Há campo(s) em branco."
            ]);

            exit();
         } else {
            $request->validate([
                'type' => 'required|int',
                'title' => 'required|string',
                'txt' => 'required|string'               
            ]);

            //AQUI SERÁ O SCRIPT DE ENVIO DA MENSAGEM PARA O(S) EMAIL(S), DANDO CONTINUIDADE O SCRIPT ABAIXO
            // ** INICIO **

            // ** FIM **

            $com = new AdmMailing();
            
            $com->insert([
                'type' => $request->type,
                'title' => $request->title,
                'txt' => $request->txt,
                'created_at' => date('Y-m-d H:i:s')
            ]);

            return response()->json([
                'status' => "success",
                'message' => "Dados salvos com sucesso."
            ]);

            exit(); 
        }

    }
}
