<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\AdmLogin;
use Carbon\Carbon;
use App\Services\EmailService;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\AdmGlobalController;

class AdmLoginController extends Controller
{
    protected $emailService;
    protected $admGlobalController;

    public function __construct(EmailService $emailService, AdmGlobalController $admGlobalController)
    {
        $this->emailService = $emailService;
        $this->admGlobalController = $admGlobalController;
    }

    // Ação para configurar e acessar a tela de Login (ADM)
    public function AdmLoginAdm ()
    {
        $logo = DB::table('tbuploads')->where(
            'type', 'logo'
        )->first();

        if($logo) {
            $link = $logo->link;
        } else {
            $link = "../inc/file/img/logo.png";
        }

        return view('adm/login', [
            'link' => $link
        ]);
    }
    // Ação para acessar o Esqueci minha senha
    public function AdmForgot ()
    {
        $logo = DB::table('tbuploads')->where(
            'type', 'logo'
        )->first();

        if($logo) {
            $link = $logo->link;
        } else {
            $link = "../inc/file/img/logo.png";
        }

        return view('adm/forgot', [
            'link' => $link
        ]);
    }
    // Ação para o envio do esqueci minha senha
    public function AdmForgotDo (Request $request)
    {
        if (isset($request)) {
            if ((!$request->email) || (!$request->confirm)) {
                return response()->json([
                   'status' => "alert",
                   'message' => "Ops! Há campo(s) obrigatório(s) em branco."
                ]);
            } else if ($request->email != $request->confirm) {
                return response()->json([
                    'status' => "alert",
                    'message' => "Ops! Os emails não conferem."
                ]);
            } else {
                $user = DB::table('tbusers')->where(
                    'email', $request->email
                )->first();

                if (!$user) {
                    return response()->json([
                        'status' => "alert",
                        'message' => "Ops! Email não cadastrado."
                    ]);
                }

                $token = bin2hex(random_bytes(16));

                DB::table('tbusers')->where(
                    'email', $request->email
                )->update([
                    'token' => $token
                ]);

                $url = url('/adm/reset/'. $token);

                $subject = "Redefinição de Senha";
                $messageBody = "Olá <b>" . $user->name . "</b>,<br><br>Recebemos uma solicitação para redefinição de senha para o acesso ao Sistema de Votação.";
                $messageBody .= "<br>Se você não realizou essa solicitação, por favor, ignore este e-mail.";
                $messageBody .= "<br>Para dar andamento a redifinição de senha e restaurar o acesso ao Sistema de Votação, <b><a href=\"" . $url . "\" target=\"_blank\">clique aqui</a></b>.<br><br>Sistema de Votação - Valida Eleições";

                // Usar o EmailService para enviar o e-mail
                $response = $this->emailService->sendEmail($request->email, $subject, $messageBody, $url);

                // Retornar a resposta do envio do e-mail
                return response()->json([
                    'status' => $response['status'],
                    'message' => $response['message']
                ]);
            }
        }
    }
    // Ação para redirecionar para a tela de Reset de Senha (ADM)
    public function AdmReset ($token)
    {
        $logo = DB::table('tbuploads')->where(
            'type', 'logo'
        )->first();

        if($logo) {
            $link = $logo->link;
        } else {
            $link = "../inc/file/img/logo.png";
        }

        $user = DB::table('tbusers')->where(
            'token', $token
        )->first();

        if (!$user) {
            return redirect('/adm');
        } else {
            return view('adm/reset', [
                'token' => $token,
                'link' => $link
            ]);
        }
    }
    // Ação para redefinir a senha
    public function AdmResetDo (Request $request)
    {
        if (isset($request)) {
            if ((!$request->password) || (!$request->confirm)) {
                return response()->json([
                   'status' => "alert",
                   'message' => "Ops! Há campo(s) obrigatório(s) em branco."
                ]);
            } else if ($request->password != $request->confirm) {
                return response()->json([
                    'status' => "alert",
                    'message' => "Ops! As senhas não conferem."
                ]);
            } else {
                $user = DB::table('tbusers')->where(
                    'token', $request->token
                )->first();

                if (!$user) {
                    return response()->json([
                        'status' => "alert",
                        'message' => "Token inválido."
                    ]);
                }

                $password = Hash::make($request->password);

                DB::table('tbusers')->where(
                    'token', $request->token
                )->update([
                    'password' => $password,
                    'token' => null
                ]);

                return response()->json([
                   'status' => "success",
                   'message' => "Senha redefinida com sucesso."
                ]);
            }
        }

    }
    // Ação para configuração e redirecionar para o CPanel
    public function AdmCPanel (Request $request)
    {
        $id = $request->session()->get('id');
        $name = $request->session()->get('name');

        if(!$id || !$name){
            return redirect('/adm');
        }else{
            return view('adm/cpanel');
        }
    }
    // Ação para acessar o Sistema (Login)
    public function AdmLoginDo (Request $request)
    {
        if (!isset($request)) {
            return response()->json([
                'status' => "alert",
                'message' => "Ops! Há campo(s) em branco."
            ]);

            exit();
        } else {
            $request->validate([
                'login' => 'required|string',
                'password' => 'required|string'
            ]);

            $login = new AdmLogin();

            $login = AdmLogin::where(
                    'login',$request->login
                )->first();

            if(!$login){
                return response()->json([
                    'status' => "alert",
                    'message' => "Registro não encontrado."
                ]);

                exit();
            } else {
                $uploads = DB::table('tbuploads')->where(
                    'type', 'logo'
                )->where(
                    'status', 1
                )->first();

                if ($uploads) {
                    $logo = $uploads->link;
                } else {
                    $logo = "../inc/file/img/logo.png";
                }

                if ($login && Hash::check($request->password,$login->password)) {

                    $configs = DB::table('tbconfigs')->select(
                        'type', 'form_aval'
                    )->first();

                    $request->session()->put('id',$login->id);
                    $request->session()->put('name',$login->name);
                    $request->session()->put('level',$login->level);
                    $request->session()->put('type',$configs->type);
                    $request->session()->put('logo',$logo);


                    $Indications = DB::table('tbelections')->where(
                        'type', 0
                    )->whereRaw(
                        'CURDATE() > date_end OR (CURDATE() = date_end AND CURTIME() >= hour_end)'
                    )->orderBy(
                        'type', 'desc'
                    )->first();

                    $noTiebreakInCards = DB::table('tbcards')->where(
                        'status_voting', '!=', 1
                    );

                    if ($Indications && $noTiebreakInCards && $configs->form_aval == 1) {
                        $this->admGlobalController->promoteCandidates();
                    }

                    return response()->json([
                        'status' => "success",
                        'message' => "Olá ".$login->name.", redirecionando...",
                        'redirect' => 1
                    ]);

                    exit();
                } else {
                    return response()->json([
                        'status' => "alert",
                        'message' => "Ops! Senha incorreta."
                    ]);

                    exit();
                }
            }
            exit();
        }
    }
    // Ação para fazer Logout do Sistema (Logout)
    public function AdmLogout(Request $request)
    {
        $request->session()->flush();
        return redirect('/adm');
    }
}
