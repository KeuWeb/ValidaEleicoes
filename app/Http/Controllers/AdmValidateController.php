<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AdmValidateController extends Controller
{
    // Validação de conta de e-mail
    public function AdmEmailDo(Request $request)
    {
        if (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            return response()->json([
                'status' => "alert",
                'message' => "E-mail digitado é inválido."
            ]); 
        } else if (!preg_match('/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,3})$/',$request->email)) {
            return response()->json([
                'status' => "alert",
                'message' => "E-mail digitado é inválido."
            ]); 
        } else {
            return response()->json([
                'status' => "success",
                'message' => "E-mail digitado é válido."
            ]); 
        }
    }
    // Ação para verificar a força da senha digitada
    public function AdmPasswordDo(Request $request)
    {
        $arr_min = array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","w","x","y","z");
        $arr_mai = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","W","X","Y","Z");
        $arr_num = array("1","2","3","4","5","6","7","8","9","0");
        $arr_cae = array("$","#","@",".","_");
    
        $verif_min = 0;
        $verif_mai = 0;
        $verif_num = 0;
        $verif_cae = 0;
    
        $qtde_caracteres = strlen($senha);
    
        for($i=0;$i<$qtde_caracteres;$i++){
    
          if(in_array($senha[$i],$arr_min)){
            $verif_min += 1;
          }
    
          if(in_array($senha[$i],$arr_mai)){
            $verif_mai += 1;
          }
    
          if(in_array($senha[$i],$arr_num)){
            $verif_num += 1;
          }
    
          if(in_array($senha[$i],$arr_cae)){
            $verif_cae += 1;
          }
        }
    
        if($verif_min > 0){
          $retorno_min = "S";
        }else{
          $retorno_min = "N";
        }
    
        if($verif_mai > 0){
          $retorno_mai = "S";
        }else{
          $retorno_mai = "N";
        }
        
        if($verif_num > 0){
          $retorno_num = "S";
        }else{
          $retorno_num = "N";
        }
        
        if($verif_cae > 0){
          $retorno_cae = "S";
        }else{
          $retorno_cae = "N";
        }
        
        $checker = array_count_values(array($retorno_min,$retorno_mai,$retorno_num,$retorno_cae));
        
        return $checker["S"];

        if ($checker == 4) {
            return response()->json([
                'status' => 'success',
                'width' => "100",
                'bgcolor' => "bg-success",
                'txt' => "senha forte"
            ]);

            exit();
        } else if($checker == 3) {
            return response()->json([
                'status' => 'success',
                'width' => "75",
                'bgcolor' => "bg-warning",
                'txt' => "senha moderada"
            ]);

            exit();
        } else if($checker == 2) {
            return response()->json([
                'status' => 'success',
                'width' => "50",
                'bgcolor' => "bg-warning",
                'txt' => "senha moderada"
            ]);

            exit();
        } else {
            return response()->json([
                'status' => 'success',
                'width' => "25",
                'bgcolor' => "bg-danger",
                'txt' => "senha fraca"
            ]);

            exit();
        }
    }
    // Ação para validar o CNPJ
    public function AdmCnpjDo(Request $request)
    {
        $cnpj = preg_replace('/[^0-9]/','',$request->cnpj);

        if(strlen($cnpj) != 14){
            return response()->json([
                'status' => "alert",
                'message' => "CNPJ digitado não possui a quantidade de caracteres obrigatória."
            ]); 
        }

        if (preg_match('/(\d)\1{13}/', $cnpj)){
            return response()->json([
                'status' => "alert",
                'message' => "CNPJ digitado é inválido."
            ]); 
        }

        $b = [6,5,4,3,2,9,8,7,6,5,4,3,2];

        for ($i = 0,$n = 0;$i < 12;$n += $cnpj[$i] * $b[++$i]);

        if ($cnpj[12] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
            return response()->json([
                'status' => "alert",
                'message' => "CNPJ digitado é inválido."
            ]); 
        }

        for ($i = 0,$n = 0; $i <= 12; $n += $cnpj[$i] * $b[$i++]);

        if ($cnpj[13] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
            return response()->json([
                'status' => "alert",
                'message' => "CNPJ digitado é inválido."
            ]); 
        }

        return response()->json([
            'status' => "success",
            'message' => "CNPJ digitado é válido."
        ]);     
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
    // Ação Validador de RG
    public function AdmRgDo(Request $request)
    {
        if (!preg_match('/^[0-9]{2,3}\.?[0-9]{2,3}\.?[0-9]{3}\-?[A-Za-z0-9]{1}$/',$request->rg)) {
            return response()->json([
                'status' => "alert",
                'message' => "RG digitado é inválido."
            ]); 
        } else {
            return response()->json([
                'status' => "success",
                'message' => "RG digitado é válido."
            ]); 
        }
    }
    // Ação para validação do CPF
    public function AdmCpfDo(Request $request)
    {
        $cpf = preg_replace('/[^0-9]/','',$request->cpf);

        if(strlen($cpf)!= 11){
            return response()->json([
                'status' => "alert",
                'message' => "CPF digitado não possui a quantidade de caracteres obrigatória."
            ]); 
        }

        if (preg_match('/(\d)\1{10}/', $cpf)){
            return response()->json([
                'status' => "alert",
                'message' => "CPF digitado é inválido."
            ]); 
        }

        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c]!= $d) {
                return response()->json([
                    'status' => "alert",
                    'message' => "CPF digitado é inválido."
                ]); 
            }
        }

        return response()->json([
            'status' => "success",
            'message' => "CPF digitado é válido."
        ]); 
    }
}
