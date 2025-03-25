<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\AdmCompany;

class AdmCompanyController extends Controller
{
    // Busca dos dados para a amostra no fomrulário, caso houver
    public function AdmCompany()
    {
        $company = DB::table('tbassociation')->select()->first();

        if (!$company) {
            return view('adm/company');
        }else{
            return view('adm/company', [
                'id' => $company->id,
                'company' => $company->company,
                'cnpj' => $company->cnpj,
                'phone' => $company->phone,
                'email' => $company->email,
                'responsible' => $company->responsible,
                'cep' => $company->cep,
                'street' => $company->street,
                'number' => $company->number,
                'complement' => $company->complement,
                'neighborhood' => $company->neighborhood,
                'city' => $company->city,
                'uf' => $company->uf
            ]);
        }
    }
    // Ação para salvar os dados no BD
    public function AdmCompanyDo(Request $request)
    {
        if (!empty($request->phone)) {
            if (!preg_match('/^(?:(?:\+|00)?(55)\s?)?(?:\(?([1-9][0-9])\)?\s?)(?:((?:9\d|[2-9])\d{3})\-?(\d{4}))$/', $request->phone)) {
                return response()->json([
                    'status' => "alert",
                    'message' => "Ops! Telefone digitado inválido."
                ]);

                exit();               
            }
        }
 
        if (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            return response()->json([
                'status' => "alert",
                'message' => "Ops! E-mail digitado inválido."
            ]);

            exit();
        }

        $request->validate([
            'company'=> 'required|string',
            'cnpj' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|string',
            'responsible' => 'required|string',
            'cep' => 'required|string',
            'street' => 'required|string',
            'number' => 'required|string',
            'complement' => 'nullable|string',
            'neighborhood' => 'required|string',
            'city' => 'required|string',
            'uf' => 'required|string'
        ]);

        $company = new AdmCompany();

        if (!empty($request->id)) {             
            $company->where(
                'id',$request->id
            )->update([
                'company' => $request->company,
                'cnpj' => $request->cnpj,
                'phone' => $request->phone,
                'email' => $request->email,
                'responsible' => $request->responsible,
                'cep' => $request->cep,
                'street' => $request->street,
                'number' => $request->number,
                'complement' => $request->complement,
                'neighborhood' => $request->neighborhood,
                'city' => $request->city,
                'uf' => $request->uf,
                'updated_at' => date('Y-m-d H:i:s')
                ]);

            $idRegistro = $request->id;
        }else{
            $company->insert([
                'company' => $request->company,
                'cnpj' => $request->cnpj,
                'phone' => $request->phone,
                'email' => $request->email,
                'responsible' => $request->responsible,
                'cep' => $request->cep,
                'street' => $request->street,
                'number' => $request->number,
                'complement' => $request->complement,
                'neighborhood' => $request->neighborhood,
                'city' => $request->city,
                'uf' => $request->uf,
                'created_at' => date('Y-m-d H:i:s')
            ]);

            $idRegistro = 1;
        }

        return response()->json([
            'status' => "success",
            'message' => "Dados salvos com sucesso.",
            'id' => $idRegistro
        ]);

        exit();  
    }
}
