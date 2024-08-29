<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\AdmRule;

class AdmRuleController extends Controller
{
    // Ação para abrir a pagina, selecionar os dados salvos no BD e mostrar no formulário
    public function AdmRule()
    {
        $rule = DB::table('tbconfigs')->select(
            'rules_login_voter',
            'rules_voter_foreigner',
            'rules_time_vote',
            'rules_qtde_dif_votes'
            )->first();

        if (!$rule) {
            return view('adm/rule');
        } else {
            return view('adm/rule', [
                'access' => $rule->rules_login_voter,
                'foreigner' => $rule->rules_voter_foreigner,
                'time' => $rule->rules_time_vote,
                'difvotes' => $rule->rules_qtde_dif_votes
            ]);
        }
    }
    // Ação para salvar os dados no BD
    public function AdmRuleDo(Request $request)
    {
        if (!isset($request)) {
            return response()->json([
                'status' => "alert",
                'message' => "Ops! Há campo(s) em branco."
            ]);

            exit();
        } else {
            if (empty($request->time)) {
                return response()->json([
                    'status' => "alert",
                    'message' => "Ops! Campo Tempo de Cabine em branco."
                ]);

                exit();
            }

            if (!preg_match('/^[0-9]{1,5}$/', $request->time)) {
                return response()->json([
                    'status' => "alert",
                    'message' => "Ops! Tempo de Cabine inválido."
                ]);

                exit();
            }

            if (empty($request->difvotes)) {
                return response()->json([
                    'status' => "alert", 
                    'message' => "Ops! Campo Porcentagem de Votos em branco."
                ]);

                exit();
            }

            if (!preg_match('/^[0-9]{1,3}$/', $request->difvotes)) {
                return response()->json([
                    'status' => "alert",
                    'message' => "Ops! Porcentagem de Votos inválido."
                ]);

                exit();
            }

            if (empty($request->foreigner)) {
                $foreigner = 1;
            } else {
                $foreigner = $request->foreigner;
            }

            $request->validate([
                'access' => 'required|int',
                'foreigner' => 'nullable|int',
                'time' => 'required|int',
                'difvotes' => 'required|int'
            ]);

            $rule = new AdmRule();
            
            $rule->where('id',1)->update([
                'rules_login_voter' => $request->access,
                'rules_voter_foreigner' => $foreigner,
                'rules_time_vote' => $request->time,
                'rules_qtde_dif_votes' => $request->difvotes
            ]);

            return response()->json([
                'status' => "success",
                'message' => "Dados salvos com sucesso."
            ]);

            exit();
        }
    }
}
