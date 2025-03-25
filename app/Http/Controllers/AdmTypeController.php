<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdmType;
use Illuminate\Support\Facades\Session;

class AdmTypeController extends Controller
{
    // Ação para acessar a pagina requisitada e busca dos dados salvos no BD
    public function AdmType()
    {
        $type = AdmType::where(
            'id',1
            )->first();

        if (!$type) {
            return view('adm/type');
        } else {
            return view('adm/type', [
                'idType' => $type->type
            ]);
        }
    }
    // Ação para salvar os dados no BD
    public function AdmTypeDo(Request $request)
    {
        if (!isset($request)) {
            return response()->json([
                'status' => "alert",
                'message' => "Ops! Há campo(s) em branco."
            ]);

            exit();
         } else {
            $type = new AdmType();

            $type = AdmType::where(
                'id',1
                )->first();

            if (!$type) {
                return response()->json([
                    'status' => "alert",
                    'message' => "Eleição não cadastrada."
                ]);

                exit();
            } else {
                $request->validate([
                    'type' => 'required|int'
                ]);

                $type->update([
                    'type' => $request->type
                ]);

                $request->session()->put('type',$request->type);

                return response()->json([
                    'status' => "success",
                    'message' => "Dado salvo com sucesso."
                ]);

                exit();
            }
         }
    }
}
