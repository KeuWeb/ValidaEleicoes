<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\AdmUsers;

class AdmUsersController extends Controller
{
    // Ação para acessar a pagina do formulário para cadastro
    public function AdmUser(){
        return view('adm/user');
    }
    // Ação para efetuar a listagem dos cadastros feitos e busca, caso houver 
    public function AdmUsers(Request $request)
    {    
        $search = $request->validate([
            'src' => 'nullable|string',
        ]);

        $query = DB::table('tbusers')->orderBy(
                'name', 'ASC'
            )->where(
                'id', '<>', 1
            )->where(
                'status', 1
            );

        if ($search) {
            $query->where(
                'name','like','%'.$search['src'].'%'
            );
        }
    
        $users = $query->get();
    
        return view('adm/users', [
            'search' => $search,
            'users' => $users
        ]);
    }
    // Ação para direcionar para a pagina da edição do cadastro selecionado
    public function AdmEditUser(AdmUsers $user)
    {
        return view('adm/user', [
            'user' => $user
        ]);
    }
    // Ação para verificar a força da senha digitada
    public function AdmPasswordDo(Request $request)
    {
        $local = base_path('public/inc/file/function.php');

        include $local;

        $checker = forcePassword($request->password);

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
    // Ação para salvar os dados no BD
    public function AdmUserDo(Request $request)
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

        if ($request->level == 0) {
            return response()->json([
                'status' => "alert",
                'message' => "Ops! Selecione um nível para o usuário."
            ]);

            exit();              
        }
 
        if (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            return response()->json([
                'status' => "alert",
                'message' => "Ops! E-mail digitado inválido."
            ]);
 
            exit();
        }

        $request->validate([
            'fullname' => 'required|string',
            'email' => 'required|string',
            'phone' => 'required|string',
            'login' => 'required|string',
            'password' => 'nullable|string',
            'level' => 'required|string'
        ]);

        $user = new AdmUsers();

        if (!empty($request->id)) {  
            if (empty($request->password)) {
                $user->where(
                    'id',$request->id
                )->update([
                    'name' => $request->fullname,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'login' => $request->login,
                    'level' => $request->level
                ]);
            } else {
                $user->where(
                    'id',$request->id
                )->update([
                    'name' => $request->fullname,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'login' => $request->login,
                    'password' => Hash::make($request->password),
                    'level' => $request->level
                ]);
            }

            return response()->json([
                'status' => "success",
                'message' => "Dados salvos com sucesso."
            ]);
 
            exit();
            
        } else {
            if (empty($request->password)) {
                return response()->json([
                    'status' => "alert",
                    'message' => "Ops! Preencher o campo senha."
                ]);
     
                exit();
            } else {
                $user->insert([
                    'name' => $request->fullname,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'login' => $request->login,
                    'password' => Hash::make($request->password),
                    'level' => $request->level,
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
    // Ação para excluir o registro no BD
    public function AdmDelUserDo(Request $request)
    {
        if (!empty($request)) {
            $user = new AdmUsers();

            $user->where(
                'id',$request->iduser
            )->update([
                'status' => 2
            ]);

            return response()->json([
                'status' => "success",
                'message' => "Registro excluido com sucesso."
            ]);
 
            exit();
        }
    }
}
