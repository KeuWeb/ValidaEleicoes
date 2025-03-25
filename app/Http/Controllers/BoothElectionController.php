<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\BoothIndication;
use App\Models\AdmCards;
use App\Models\AdmCandidates;
use App\Http\Controllers\AdmGlobalController;

class BoothElectionController extends Controller
{
    protected $admGlobalController;

    public function __construct(AdmGlobalController $admGlobalController)
    {
        $this->admGlobalController = $admGlobalController;
    }
    // Ação para redirercionamento para o formulário para eleição
    public function BoothElection(AdmCards $card)
    {
        if ($card) {
            // Busca os candidatos associados à cédula
            $candidates = AdmCandidates::where('type', 1)
                ->where('status', 1)
                ->where('card', $card->id) // Relacionando a cédula com os candidatos
                ->orderBy('name', 'asc') // Ordenando pelo nome
                ->with('photoUpload') // Carrega a foto associada ao candidato
                ->get();
        }

        return view('booth/election', [
            'candidates' => $candidates,
            'card' => $card
        ]);
    }
    // Ação para geração das informações da modal (Booth > Eleição)
    public function BoothElectionInfo(Request $request)
    {
        if ($request) {
            $candidate = AdmCandidates::where(
                'id', $request->idCandidate
            )->where(
                'status', 1
            )->first();
        } else {
            $candidate = null;
        }

        if ($candidate) {
            if ($candidate->curriculum) {
                $curriculum = $candidate->curriculum;
            } else {
                $curriculum = 'Não disponível.';
            }

            $HTML = "<div class=\"d-flex justify-content-center\">
                        <h4 class=\"w-100 text-center\"><b>INFORMAÇÕES</b></h4>
                        <a href=\"#\" class=\"btn btn-danger btn-close-modal-info\"><b class=\"text-white\">X</b></a>
                    </div>
                    <p class=\"pt-3 mx-0 px-0\">" . $candidate->obs . "</p>
                    <b>Link externo:</b> <a href=\"" . $curriculum . "\" target=\"_blank\" class=\"text-success\">clique aqui</a>";

            return response()->json([
                'status' => "success",
                'message' => "Informação encontrada com sucesso.",
                'html' => $HTML
            ]);
        } else {
            return response()->json([
                'status' => "alert",
                'message' => "Ops! Informação não encontrada."
            ]);
        }
    }
    // Ação para redirercionamento para a pagina de confirmação
    public function BoothConfirm(Request $request)
    {
        $id = $request->session()->get('id');
        $type = $request->session()->get('type');
        $confirm = $request->session()->put('confirm', true);

        $election = DB::table('tbelections')->where(
            'type', $type
        )->first();

        $configs = DB::table('tbconfigs')->where(
            'id', 1
        )->first();

        $voting = DB::table('tbvotings')->where(
            'type', $type
        )->where(
            'voter', $id
        )->first();

        if ($voting) {
            if ($voting->code) {
                $code = $voting->code;
            } else {
                $code = $this->admGlobalController->generateTokenCode();

                DB::table('tbvotings')->where(
                    'type', $type
                )->where(
                    'voter', $id
                )->update([
                    'code' => $code
                ]);
            }
        }

        return view('booth/confirm', [
            'configs' => $configs,
            'election' => $election,
            'code' => $code
        ]);
    }
    // Ação para efetuar as tratativas do formulário de indicação (booth)
    public function BoothElectionDo(Request $request)
    {
        if ($request) {
            if ((!empty($request->idCandidates) && $request->voteNull == 1) || (!empty($request->idCandidates) && $request->voteWhite == 1)) {
                return response()->json([
                    'status' => "alert",
                    'message' => "Ops! Somente pode escolher uma opção de voto."
                    ]);
            } else {
                if (empty($request->idCandidates)) {
                    if ($request->voteNull == 0 && $request->voteWhite == 0) {
                        return response()->json([
                            'status' => "alert",
                            'message' => "Ops! Deve escolher uma opção de voto."
                        ]);
                    } else if ($request->voteWhite == 1 && $request->voteNull == 1) {
                        return response()->json([
                            'status' => "alert",
                            'message' => "Ops! Somente pode escolher uma opção de voto."
                        ]);
                    } else {
                        if ($request->voteNull == 1) {
                            $idIndication = 99;
                        } else if ($request->voteWhite == 1) {
                            $idIndication = 88;
                        } else {
                            return response()->json([
                                'status' => "alert",
                                'message' => "Ops! Deve escolher uma opção de voto."
                            ]);
                        }
                        $logInfo = $this->admGlobalController->getUserInfo($request);

                        DB::table('tbvotings')->insert([
                            'type' => 1,
                            'card' => $request->card,
                            'candidate' => $idIndication,
                            'voter' => session()->get('id'),
                            'log_info' => $logInfo
                        ]);
                    }
                } else {
                    if (empty($request->idCandidates) || $request->idCandidates == '') {
                        return response()->json([
                            'status' => "alert",
                            'message' => "Ops! Deve escolher ao menos um candidato."
                        ]);
                    } else {
                        $logInfo = $this->admGlobalController->getUserInfo($request);

                        $arrIds = explode(',', $request->idCandidates);

                        foreach ($arrIds as $candidateId) {
                            if (!empty($candidateId)) {
                                DB::table('tbcandidates')->where(
                                    'id', $candidateId
                                )->increment(
                                    'votes_election', 1
                                );

                                DB::table('tbvotings')->insert([
                                    'type' => 1,
                                    'card' => $request->card,
                                    'candidate' => $candidateId,
                                    'voter' => session()->get('id'),
                                    'log_info' => $logInfo
                                ]);
                            }
                        }
                    }
                }

                $card = DB::table('tbcards')->where(
                    'id', '>', $request->card
                )->where(
                    'category', $request->session()->get('category')
                )->where(
                    'local', $request->session()->get('local')
                )->where(
                    'status', 1
                )->orderBy(
                    'id', 'asc'
                )->orderBy(
                    'order', 'asc'
                )->first();

                if ($card) {
                    $request->session()->put('card',$card->id);
                    $route = "/booth/election/" . $card->id;
                } else {
                    $route = "/booth/confirm";
                }

                return response()->json([
                    'status' => "success",
                    'message' => "Voto computado com sucesso!",
                    'route' => $route
                 ]);
            }
        } else {
            return response()->json([
                'status' => "alert",
                'message' => "Ops! Há campo(s) obrigatório(s) em branco."
            ]);
        }
    }
}
