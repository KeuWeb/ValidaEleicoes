<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\BoothIndication;
use App\Models\AdmCards;
use App\Http\Controllers\AdmGlobalController;

class BoothIndicationController extends Controller
{
    protected $admGlobalController;

    public function __construct(AdmGlobalController $admGlobalController)
    {
        $this->admGlobalController = $admGlobalController;
    }
    // Ação para redirercionamento para o formulário para indicação
    public function BoothIndication(AdmCards $card)
    {
        if (session()->has('confirm')) {
            return redirect()->route('booth.logout');
        }

        if ($card) {
            $indications = BoothIndication::where(
                'type', 0
            )->where(
                'card', $card->id
            )->where(
                'status', 1
            )->orderBy(
                'name', 'asc'
            )->get();


            if ($indications) {
                $listIndications = "";

                foreach ($indications as $indication) {
                    $listIndications.= "
                        <a href=\"#\" data-button=\"" . $indication->id . "\" class=\"dynamic-list btn-list" . $indication->id . " list-group-item list-group-item-action flex-column align-items-start\">
                            <div class=\"d-flex w-100 justify-content-between\">
                            <h5 class=\"mb-0 fs-6\"><b>" . $indication->name . "</b></h5>
                            </div>
                            <p class=\"mb-1\" style=\"font-size: 0.9em;\">" . $indication->obs . "</p>
                        </a>
                    ";
                }
            }

            return view('booth/indication', [
                'listIndications' => $listIndications,
                'card' => $card
            ]);
        }
    }
    // Ação para efetuar as tratativas fdo formulário de indicação (booth)
    public function BoothIndicationDo(Request $request)
    {
        if ($request) {
            if ((!empty($request->name) && !empty($request->idCandidate)) || (!empty($request->obs) && !empty($request->idCandidate))) {
                return response()->json([
                    'status' => "alert",
                    'message' => "Ops! Somente pode escolher uma opção de indicação."
                 ]);
            } else {
                if ($request->idCandidate) {
                    BoothIndication::where(
                        'id', $request->idCandidate
                    )->increment(
                        'votes_indication', 1
                    );

                    $idIndication = $request->idCandidate;
                } else {
                    if (empty($request->name) || empty($request->obs)) {
                        return response()->json([
                            'status' => "alert",
                            'message' => "Ops! O campo NOME e MOTIVO devem ser preenchidos."
                         ]);
                    } else {
                        $verifyCandidate = BoothIndication::where(
                            'id', $request->name
                        )->where(
                            'status', 1
                        )->first();

                        if ($verifyCandidate) {
                            return response()->json([
                                'status' => "alert",
                                'message' => "Ops! Já existe indicado com o mesmo NOME mencionado."
                             ]);
                        } else {
                            $indication = new BoothIndication();

                            $indication->insert([
                                'type' => 0,
                                'name' => $request->name,
                                'category' => $request->session()->get('category'),
                                'local' => $request->session()->get('local'),
                                'card' => $request->card,
                                'obs' => $request->obs,
                                'votes_indication' => 1,
                                'created_at' => date('Y-m-d H:i:s')
                            ]);

                            $idIndication = $indication->latest()->first()->id;
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
                    $route = "/booth/indication/" . $card->id;
                } else {
                    $route = "/booth/confirm";
                }

                $logInfo = $this->admGlobalController->getUserInfo($request);

                DB::table('tbvotings')->insert([
                    'type' => 0,
                    'card' => $request->card,
                    'candidate' => $idIndication,
                    'voter' => session()->get('id'),
                    'log_info' => $logInfo
                ]);

                return response()->json([
                   'status' => "success",
                   'message' => "Indicação efetuada com sucesso!",
                   'idIndication' => $idIndication,
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
