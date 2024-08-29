<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use App\Models\AdmCompany;

class AdmCompanyController extends Controller
{
    // Busca dos dados para a amostra no fomrulário, caso houver
    public function AdmCompany()
    {
        $company = DB::table('tbelections')->select()->first();

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
    // Ação para validar o CNPJ
    public function AdmCnpjDo(Request $request)
    {
        $local = base_path('public/inc/file/function.php');

        if (file_exists($local)) {
            include $local;

            if (validateCNPJ($request->cnpj) === false) {
                return response()->json([
                    'status' => "alert",
                    'message' => "Ops! CNPJ inválido."
                ]);

                exit();
            }else{
                return response()->json([
                    'status' => "success",
                    'message' => "CNPJ válido."
                ]);

                exit();
            }
        }else{
            return response()->json([
                'status' => "error",
                'message' => "Erro ao validar o CNPJ."
            ]);

            exit();
        }        
    }
    // Ação para captura de dados de endereço por CEP via API externa
    public function AdmCepDo(Request $request)
    {
        $data = Http::get(url:"https://viacep.com.br/ws/{$request->cep}/json/")->json();

        if ($data) {   
            if (!empty($data['erro'])) {
                return response()->json([
                    'status' => "alert",
                    'message' => "Ops! Endereço não encontrado."
                ]);
            }else{
                return $data;
            }
        }

        return false;
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
            $company->where('id',$request->id)->update([
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
                'date_str_ind' => date('1970-01-01 00:00:00'),
                'date_end_ind' => date('1970-01-01 00:00:00'),
                'date_str_ele' => date('1970-01-01 00:00:00'),
                'date_end_ele' => date('1970-01-01 00:00:00'),
                'date_investigation' => date('1970-01-01 00:00:00'),
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
