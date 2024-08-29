<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// use App\Models\AdmElection;

class AdmElectionController extends Controller
{
    // Ação para visualizar apagina bem como seus respectivos dados
    public function AdmElection()
    {
        $type = DB::table('tbconfigs')->select(
            'type'
            )->first();

        if (!$type) {
            return view('adm/election');
        }else{
            return view('adm/election',[
                'type' => $type->type
            ]);
        }
    }
    // Ação para salvar os dados no BD
    public function AdmElectionDo(Request $request)
    {
        if(!filter_var($request->email,FILTER_VALIDATE_EMAIL)){
            return response()->json([
                'status' => "alert",
                'message' => "Ops! E-mail digitado inválido."
            ]);

            exit();
        }
    }
}
