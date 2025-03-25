<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\BoothLogin;
use Carbon\Carbon;
use App\Services\EmailService;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\AdmGlobalController;

class BoothLoginController extends Controller
{
    protected $emailService;
    protected $admGlobalController;

    public function __construct(EmailService $emailService, AdmGlobalController $admGlobalController)
    {
        $this->emailService = $emailService;
        $this->admGlobalController = $admGlobalController;
    }
    // Ação para configurar e acessar a tela de Login (ADM)
    public function BoothLoginBooth ()
    {
        $logo = DB::table('tbuploads')->where(
            'type', 'logo'
        )->first();

        if($logo) {
            $link = $logo->link;
        } else {
            $link = "../inc/file/img/logo.png";
        }

        $configs = DB::table('tbconfigs')->where(
            'id', 1
        )->first();

        if ($configs) {
            if ($configs->type >= 3) {
                $phase = "Acesso a cabine de indicação/votação";
            } else {
                $phase = "Acesso a cabine de votação";
            }

            if ($configs->rules_voter_foreigner == 2) {
                $lbForeigner = " ou Passaporte";
            } else {
                $lbForeigner = "";
            }

            if ($configs->rules_login_voter == 1) {
                $lbLogin = "CPF";
            } else if ($configs->rules_login_voter == 2) {
                $lbLogin = "E-mail";
            } else if ($configs->rules_login_voter == 3) {
                $lbLogin = "Matrícula";
            } else {
                $lbLogin = "Login";
            }
        }

        return view('booth/login', [
            'link' => $link,
            'phase' => $phase,
            'login' => $lbLogin,
            'foreigner' => $lbForeigner,
            'configs' => $configs
        ]);
    }
    // Ação para acessar o Esqueci minha senha
    public function BoothForgot ()
    {
        $logo = DB::table('tbuploads')->where(
            'type', 'logo'
        )->first();

        if($logo) {
            $link = $logo->link;
        } else {
            $link = "../inc/file/img/logo.png";
        }

        return view('booth/forgot', [
            'link' => $link
        ]);
    }
    // Ação para o envio do esqueci minha senha
    public function BoothForgotDo (Request $request)
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
                $voter = DB::table('tbvoters')->where(
                    'email', $request->email
                )->first();

                if (!$voter) {
                    return response()->json([
                        'status' => "alert",
                        'message' => "Ops! Email não cadastrado."
                    ]);
                }

                $token = bin2hex(random_bytes(16));

                DB::table('tbvoters')->where(
                    'email', $request->email
                )->update([
                    'token' => $token
                ]);

                $url = url('/booth/reset/'. $token);

                $subject = "Redefinição de Senha";
                $messageBody = "Olá <b>" . $voter->fullname . "</b>,<br><br>Recebemos uma solicitação para redefinição de senha para o acesso ao Sistema de Votação.";
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
    // Ação para redirecionar para a tela de Reset de Senha (Eleitor)
    public function BoothReset ($token)
    {
        $logo = DB::table('tbuploads')->where(
            'type', 'logo'
        )->first();

        if($logo) {
            $link = $logo->link;
        } else {
            $link = "../inc/file/img/logo.png";
        }

        $user = DB::table('tbvoters')->where(
            'token', $token
        )->first();

        if (!$user) {
            return redirect('/booth');
        } else {
            return view('booth/reset', [
                'token' => $token,
                'link' => $link
            ]);
        }
    }
    // Ação para redefinir a senha
    public function BoothResetDo (Request $request)
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
                $user = DB::table('tbvoters')->where(
                    'token', $request->token
                )->first();

                if (!$user) {
                    return response()->json([
                        'status' => "alert",
                        'message' => "Token inválido."
                    ]);
                }

                $password = Hash::make($request->password);

                DB::table('tbvoters')->where(
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
    // Ação para acessar o Sistema (Login)
    public function BoothLoginDo (Request $request)
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
                'password' => 'required|string',
                'type' => 'required|string'
            ]);

            $login = new BoothLogin();

            if ($request->type == 1) {
                $colunm = "cpf";
                $valueLogin = preg_replace('/[.\-]/', '', trim($request->login));
            } else if ($request->type == 2) {
                $colunm = "email";
                $valueLogin = trim($request->login);
            } else {
                $colunm = "other_login";
                $valueLogin = preg_replace('/[.\-\/]/', '', trim($request->login));
            }

            if ($request->type == 2) {
                $login = BoothLogin::where(
                    $colunm, $valueLogin
            );
            } else {
                $login = BoothLogin::whereRaw(
                    "REPLACE(REPLACE(REPLACE($colunm, '.', ''), '-', ''), '/', '') = ?", [$valueLogin]
                );
            }

            if ($request->foreigner == 2) {
                $login = $login->orWhereRaw(
                    "REPLACE(REPLACE(REPLACE(other_doc, '.', ''), '-', ''), '/', '') = ?", [$valueLogin]
                );
            }

            $login = $login->first();

            if(!$login){
                return response()->json([
                    'status' => "alert",
                    'message' => "Registro não encontrado."
                ]);

            } else if ($login->status == 2) {
                return response()->json([
                    'status' => "alert",
                    'message' => "Registro excluído ou bloqueado. Entrar em contato com a Administração."
                ]);
                exit();
            } else {
                $election = DB::table('tbelections')->where(
                    'status', 1
                )->whereRaw(
                    '? BETWEEN date_initial AND date_end', [date('Y-m-d')]
                )->whereRaw(
                    '? BETWEEN hour_initial AND hour_end', [date('H:i')]
                )->orderBy(
                    'type', 'desc'
                )->first();

                if ($election) {
                    $dateIniHourBD = Carbon::parse("{$election->date_initial} {$election->hour_initial}");
                    $dateEndHourBD = Carbon::parse("{$election->date_end} {$election->hour_end}");
                    $dateHourNow = Carbon::now();

                    $Indications = DB::table('tbelections')->where(
                        'type', 0
                    )->whereRaw(
                        'CURDATE() > date_end OR (CURDATE() = date_end AND CURTIME() >= hour_end)'
                    )->orderBy(
                        'type', 'desc'
                    )->first();

                    $noTiebreakInCards = DB::table('tbcards')->where(
                        'status_voting', '<>', 1
                    )->exists();

                    $configs = DB::table('tbconfigs')->where(
                        'id', 1
                    )->first();

                    if ($Indications && $noTiebreakInCards && $configs->form_aval == 1) {
                        $this->admGlobalController->promoteCandidates();
                    }

                    if ($election->type == 1) {
                        $typeTxtElection = "da eleição";
                        $votingTxt = "Seu voto já foi efetivado.";
                    } else {
                        $typeTxtElection = "de indicação";
                        $votingTxt = "Sua indicação já foi efetivada.";
                    }

                    $request->session()->put('type',$election->type);

                    if ($dateHourNow < $dateIniHourBD) {
                        return response()->json([
                            'status' => "alert",
                            'message' => "Processo " . $typeTxtElection . " não iniciado."
                        ]);
                    } else if ($dateHourNow > $dateEndHourBD) {
                        return response()->json([
                            'status' => "alert",
                            'message' => "Processo " . $typeTxtElection . " finalizado."
                        ]);
                    } else if ($noTiebreakInCards) {
                        return response()->json([
                            'status' => "alert",
                            'message' => "Processo de análise de indicados não finalizado."
                        ]);
                    }
                } else {
                    return response()->json([
                        'status' => "alert",
                        'message' => "Processo eleitoral não iniciado ou finalizado."
                    ]);
                }

                if ($login && Hash::check($request->password,$login->password)) {

                    $voting = DB::table('tbvotings')->where(
                        'voter', $login->id
                    )->where(
                        'type', $election->type
                    )->first();

                    // dd($voting);

                    if ($voting) {
                        return response()->json([
                            'status' => "alert",
                            'message' => "Ops! " . $votingTxt
                        ]);
                    }

                    if ($login->cpf) {
                        $doc = $login->cpf;
                    } else if ($login->other_login) {
                        $doc = $login->other_login;
                    } else if ($login->other_doc) {
                        $doc = $login->other_doc;
                    } else {
                        $doc = "-";
                    }

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

                    $request->session()->put('id',$login->id);
                    $request->session()->put('doc',$doc);
                    $request->session()->put('name',$login->fullname);
                    $request->session()->put('type',$election->type);
                    $request->session()->put('logo',$logo);
                    $request->session()->put('local',$login->local);
                    $request->session()->put('category',$login->category);

                    $fullname = explode(" ", $login->fullname);

                    return response()->json([
                        'status' => "success",
                        'message' => "Olá ".$fullname[0].", redirecionando...",
                        'redirect' => 2
                    ]);
                } else {
                    return response()->json([
                        'status' => "alert",
                        'message' => "Ops! Senha incorreta."
                    ]);
                }
            }

            exit();
        }
    }
    // Ação para configuração e redirecionar para o CPanel
    public function BoothCPanel (Request $request)
    {
        $id = $request->session()->get('id');
        $name = $request->session()->get('name');
        $type = $request->session()->get('type');
        $category = $request->session()->get('category');
        $local = $request->session()->get('local');

        if(!$id || !$name){
            return redirect('/booth');
        }else{
            $configs = DB::table('tbconfigs')->where(
                'id', 1
            )->first();

            $election = DB::table('tbelections')->where(
                'type', $type
            )->first();

            $card = DB::table('tbcards')->leftJoin(
                'tbvotings', function ($join) use ($id) {
                    $join->on(
                        'tbcards.id', '=', 'tbvotings.card'
                    )->where(
                        'tbvotings.voter', '=', $id
                    );
            })->where(
                function ($query) use ($id) {
                    $query->whereNull('tbvotings.card')->orWhere(
                        'tbvotings.voter', '=', $id
                    );
            })->where(
                'tbcards.category', $category
            )->where(
                'tbcards.local', $local
            )->where(
                'tbcards.status', 1
            )->orderBy(
                'tbcards.order', 'asc'
            )->select('tbcards.*')->first();


            if ($card) {
                $request->session()->put('card', $card->id);
            } else {
                $request->session()->put('card', 0);
            }

            $request->session()->put('time', $configs->rules_time_vote);

            return view('booth/cpanel', [
                'configs' => $configs,
                'election' => $election
            ]);
        }
    }
    // Ação para fazer Logout do Sistema (Logout)
    public function BoothLogout(Request $request)
    {
        $request->session()->flush();
        return redirect('/booth');
    }
}
