<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\AdmCommunication;

class AdmCommunicationController extends Controller
{
    // Acesso a pagina de Comunicação com os dados salvos no BD
    public function AdmCommunication()
    {
        $com = DB::table('tbconfigs')->select()->first();

        return view('adm/communication', [
            'com_whatsapp' => $com->com_whatsapp,
            'com_txt_whatsapp' => $com->com_txt_whatsapp,
            'com_first' => $com->com_first,
            'com_end' => $com->com_end,
            'com_message' => $com->com_message
        ]);
    }
    // Requisição para efetuar a gravação dos dados editados no BD
    public function AdmCommunicationDo(Request $request)
    {
        if (!isset($request)) {
            return response()->json([
                'status' => "alert",
                'message' => "Ops! Há campo(s) em branco."
            ]);

            exit();
        }else{   
            $request->validate([
                'whatsapp' => 'nullable|string',
                'txt_whatsapp' => 'nullable|string',
                'txt_welcome' => 'required|string',
                'txt_finish' => 'required|string',
                'txt_message' => 'required|string'

            ]);

            $com = new AdmCommunication();

            $com->where(
                'id', 1
                )->update([
                'com_whatsapp' => $request->whatsapp,
                'com_txt_whatsapp' => $request->txt_whatsapp,
                'com_first' => $request->txt_welcome,
                'com_end' => $request->txt_finish,
                'com_message' => $request->txt_message
                ]);

            return response()->json([
                'status' => "success",
                'message' => "Dados salvos com sucesso."
            ]);

            exit(); 
         }
    }
}
