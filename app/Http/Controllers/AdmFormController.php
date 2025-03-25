<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\AdmForm;

class AdmFormController extends Controller
{
    // Ação para direcionar a pagina e visualizar seus respectivo formulário
    public function AdmForm()
    {
        $com = DB::table('tbconfigs')->select(
            'form_local',
            'form_category',
            'form_aval'
        )->first();

        return view('adm/form', [
            'local' => $com->form_local,
            'category' => $com->form_category,
            'aval' => $com->form_aval
        ]);
    }
    // Ação para salvar os dados no BD
    public function AdmFormDo(Request $request)
    {
        if (!isset($request)) {
            return response()->json([
                'status' => "alert",
                'message' => "Ops! Há campo(s) em branco."
           ]);

            exit();
         } else {
            $form = new AdmForm();
            
            $form = AdmForm::where(
                    'id', 1
                )->first();

            if (!$form) {
                return response()->json([
                    'status' => "alert",
                    'message' => "Regras não configuradas. Cadastre a eleição primeiro."
                ]);

                exit();               
            } else {
                $request->validate([
                    'aval' => 'required|int',
                    'local' => 'required|int',
                    'category' => 'nullable|int'                    
                ]);

                if ($request->category == null) {
                    $category = 2;
                } else {
                    $category = 1;
                }

                $form->where(
                    'id',1
                    )->update([
                    'form_aval' => $request->aval,
                    'form_local' => $request->local,
                    'form_category' => $category
                ]);

                return response()->json([
                    'status' => "success",
                    'message' => "Dados salvos com sucesso."
                ]);

                exit();  
            }
        }
    }
}
