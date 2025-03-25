<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AdmValidateController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\AdmUsers;

class AdmUsersController extends Controller
{
    protected $admValidateController;

    public function __construct(AdmValidateController $admValidateController)
    {
        $this->admValidateController = $admValidateController;
    }
    // Ação para acessar a pagina do formulário para cadastro
    public function AdmUser()
    {
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

            $idUser = $request->id;
        } else {
            if (!empty($request->email)) {
                $checkerEmail = $this->admValidateController->AdmCheckCadDo('tbusers', 'email', $request->email, 'e-mail');

                if($checkerEmail) {
                    return $checkerEmail;
                }
            }

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

                $idUser = $user->latest()->first()->id;
            }
        }

        return response()->json([
            'status' => "success",
            'message' => "Dados salvos com sucesso.",
            'id' => $idUser
        ]);

        exit();
    }
    // Ação para excluir o registro no BD
    public function AdmDelUserDo(Request $request)
    {
        if (!empty($request)) {
            $user = new AdmUsers();

            $user->where(
                'id',$request->idDelete
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
