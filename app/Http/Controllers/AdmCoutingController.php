<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\AdmCandidates;
use App\Models\AdmCards;
use App\Http\Controllers\AdmGlobalController;

class AdmCoutingController extends Controller
{
    protected $admGlobalController;

    public function __construct(AdmGlobalController $admGlobalController)
    {
        $this->admGlobalController = $admGlobalController;
    }

    public function AdmCoutingIndicates(Request $request)
    {
        $search = $request->validate([
            'src' => 'nullable|string',
        ]);

        $query = DB::table('tbcards')->leftJoin(
            'tbcandidates', 'tbcards.id', '=', 'tbcandidates.card'
        )->select(
            'tbcards.*',
            DB::raw(
                'COUNT(CASE WHEN tbcandidates.type = 0 THEN 1 END) as qtd_indicates'
            ),
            DB::raw(
                'COUNT(CASE WHEN tbcandidates.type = 1 THEN 1 END) as qtd_candidates'
            ),
            DB::raw(
                'COUNT(CASE WHEN tbcandidates.type = 3 THEN 1 END) as qtd_rejects'
            )
        )->where(
            'tbcards.status', 1
        )->groupBy(
            'tbcards.id'
        )->orderBy(
            'tbcards.title', 'ASC'
        );

    if (!empty($search['src'])) {
        $query->where(
            'tbcards.title', 'like', '%' . $search['src'] . '%'
        );
    }

    $cards = $query->get();

    $indication = DB::table('tbelections')->where(
        'type', 0
    )->first();

        return view('adm/coutingIndicates', [
            'search' => $search,
            'cards' => $cards,
            'indication' => $indication
        ]);
    }
    // Ação para direcionamento e conteudo da listagem de inscritos (indicados e candidatos) módulo Apuração > Indicações
    public function AdmCoutingIndicatesList(Request $request, $card, $type)
    {
        $search = $request->validate([
            'src' => 'nullable|string',
        ]);

        $query = AdmCandidates::where(
            'tbcandidates.card', $card
        )->where(
            'tbcandidates.type', $type
        )->where(
            'tbcandidates.status', 1
        )->leftJoin(
            'tbcards', 'tbcards.id', '=', 'tbcandidates.card'
        )->select(
            'tbcandidates.id as tbcandidates_id', 'tbcards.id as tbcards_id', 'tbcandidates.*', 'tbcards.*'
        )->orderBy(
            'tbcandidates.votes_indication', 'DESC'
        );

        if (!empty($search['src'])) {
            $query->where(
                'name', 'like', '%' . $search['src'] . '%'
            );
        }

        $candidates = $query->get();
        $cards = $query->first();

        return view('adm/coutingListIndicates', [
            'candidates' => $candidates,
            'cards' => $cards,
            'type' => $type
        ]);
    }
    // Ação para atualizar indicado como Deferido ou Indefetido
    public function AdmCoutingIndicatesListDo(Request $request)
    {
        if ($request->type == "defer") {
            $type = 1;
        } else if ($request->type == "reject") {
            $type = 3;
        } else {
            return response()->json([
               'status' => "alert",
               'message' => "Ops! Selecione uma opção válida."
            ]);
        }

        AdmCandidates::where(
            'id', $request->idIndidate
        )->update([
            'type' => $type
        ]);

        $qtdeCandidates = AdmCandidates::where(
            'status', 1
        )->where(
            'type', 1
        )->where(
            'card', $request->card
        )->count();

        if ($qtdeCandidates == $request->limitIndicates) {
            DB::table('tbcards')->where(
                'id', $request->card
            )->update([
                'status_voting' => 1
            ]);
        }

        return response()->json([
           'status' => "success",
           'message' => "Inscrição atualizada com sucesso."
        ]);
    }
    // Ação para a listagem dos candidatos da eleição vigente (Módulo Apuração > Eleição)
    public function AdmCoutingCandidates(Request $request)
    {
        $search = $request->validate([
            'src' => 'nullable|string',
        ]);

        $query = AdmCards::where('status', 1)->orderBy(
            'order')->with(
                [
                    'candidates' => function ($query) {
                        $query->select('id', 'card', 'name');
                    }
                ]
            );

        if (!empty($search['src'])) {
            $query->where(
                'title', 'like', '%' . $search['src'] . '%'
            );
        }

        $cards = $query->get()->map(function ($card) {

            $candidatesList = [];

            foreach ($card->candidates as $candidate) {
                $votes = DB::table('tbvotings')->where(
                    'card', $card->id
                )->where(
                    'type', 1
                )->where(
                    'candidate', $candidate->id
                )->count();

                $candidatesList[] = [
                    'id' => $candidate->id,
                    'name' => $candidate->name,
                    'votes' => $votes,
                ];
            }

            $blankVotes = DB::table('tbvotings')->where(
                'card', $card->id
                )->where(
                    'type', 1
                )->where(
                    'candidate', 88
                )->count();

            $nullVotes = DB::table('tbvotings')->where(
                'card', $card->id
                )->where(
                    'type', 1
                )->where(
                    'candidate', 99
                )->count();

            $candidatesList[] = ['id' => 88, 'name' => 'Branco', 'votes' => $blankVotes];
            $candidatesList[] = ['id' => 99, 'name' => 'Nulo', 'votes' => $nullVotes];

            usort($candidatesList, function ($a, $b) {
                return $b['votes'] <=> $a['votes'];
            });

            return (object) [
                'id' => $card->id,
                'title' => $card->title,
                'totalVotes' => array_sum(array_column($candidatesList, 'votes')),
                'candidatesList' => $candidatesList,
            ];
        });

        $election = DB::table('tbelections')->where(
            'type', 1
        )->first();

        return view('adm/coutingCandidates', [
            'search' => $search,
            'cards' => $cards,
            'election' => $election
        ]);
    }
    // Ação para direcionar para a view da pagina de Eleitores (Apuração > Eleitores)
    public function AdmCoutingVoters(Request $request)
    {
        $voters = DB::table('tbvotings as v')->join(
            'tbvoters as e', 'v.id', '=', 'e.id'
        )->select(
            'v.id', 'e.fullname'
        )->groupBy(
            'v.id'
        )->orderBy(
            'e.fullname', 'ASC'
        )->get();

        return view('adm/coutingVoters', [
            'voters' => $voters
        ]);
    }
    // Ação para visualizar as informações do eleitor selecionado (Apuração Eleitores)
    public function AdmVoterInfo(Request $request)
    {
        $voter = DB::table('tbvoters')->where(
            'id', $request->idVoter
        )->first();

        $votings = DB::table('tbvotings')->selectRaw(
            'type, ANY_VALUE(id) as id, ANY_VALUE(voter) as voter, ANY_VALUE(created_at) as created_at, ANY_VALUE(log_info) as log_info'
        )->where(
            'voter', $request->idVoter
        )->groupBy(
            'type'
        )->orderBy(
            'type', 'ASC'
        )->get();

        if ($votings->isempty()) {
            $participate = 'Ainda não participou de nenhum processo eleitoral.';

            $HTML = "<li class=\"col-12\"><b>Eleitor: " . $voter->fullname . "</b></li>
                     <li class=\"col-12\"><i class=\"bi bi-info-square me-1 text-success\"></i> ". $participate . "</li>";
        } else {
            $participate = '';
            $dateVote = '';
            $ipVote = '';
            $deviceVote = '';
            $browserVote = '';
            $soVote = '';
            $mobileVote = '';

            foreach ($votings as $voting) {
                $arr_data = explode(';', $voting->log_info);

                if ($voting->type == 0) {
                    $participate .= 'participou da indicação; ';
                    $dateVote .= 'indicação (' . date('d/m/Y - H:i',strtotime($voting->created_at)) . '); ';
                    $ipVote .= 'indicação (' . trim($arr_data[0]) . '); ';
                    $deviceVote .= 'indicação (' . trim($arr_data[1]) . '); ';
                    $browserVote .= 'indicação (' . trim($arr_data[2]) . '); ';
                    $soVote .= 'indicação (' . trim($arr_data[3]) . '); ';
                    $mobileVote .= 'indicação (' . trim($arr_data[4]) .'); ';
                }

                if ($voting->type == 1) {
                    $participate .= 'participou da eleição';
                    $dateVote .= 'eleição (' . date('d/m/Y - H:i',strtotime($voting->created_at)) . ');';
                    $ipVote .= 'eleição (' . trim($arr_data[0]) .');';
                    $deviceVote .= 'eleição (' . trim($arr_data[1]) . ');';
                    $browserVote .= 'eleição (' . trim($arr_data[2]) . ');';
                    $soVote .= 'eleição (' . trim($arr_data[3]) . ');';
                    $mobileVote .= 'eleição (' . trim($arr_data[4]) .');';
                }
            }

            $HTML = "<li class=\"col-12\"><b>Eleitor: " . $voter->fullname . "</b></li>
                     <li class=\"col-12\"><i class=\"bi bi-info-square me-1 text-success\"></i> " . $participate . "</li>
                     <li class=\"col-12\"><i class=\"bi bi-calendar-check me-1 text-success\"></i> " . $dateVote . "</li>
                     <li class=\"col-12\"><i class=\"bi bi-router me-1 text-success\"></i> " . $ipVote . "</li>
                     <li class=\"col-12\"><i class=\"bi bi-phone me-1 text-success\"></i> " . $mobileVote . "</li>
                     <li class=\"col-12\"><i class=\"bi bi-pc-display-horizontal me-1 text-success\"></i> " . $deviceVote . "</li>
                     <li class=\"col-12\"><i class=\"bi bi-cpu me-1 text-success\"></i> " . $soVote . "</li>
                     <li class=\"col-12\"><i class=\"bi bi-window me-1 text-success\"></i> " . $browserVote . "</li>";
        }

        return response()->json([
            'status' => "success",
            'message' => "Informação encontrada com sucesso.",
            'html' => $HTML
        ]);
    }
    // Ação para imprimir a apuração dos votos (Apuração > Eleição)
    public function AdmPrintElection() {
        $query = AdmCards::where('status', 1)->orderBy('order')->with([
            'candidates' => function ($query) {
                $query->select('id', 'card', 'name');
            }
        ]);

        $cardsNames = AdmCards::where(
            'status', 1
        )->pluck(
            'title'
        )->toArray();

        $cardsNames = implode(', ', $cardsNames);

        $cards = $query->get()->map(function ($card) use ($cardsNames) {

            $candidatesList = [];

            $mostVotedCandidate = DB::table('tbvotings')->select(
                'candidate', DB::raw(
                    'count(*) as votes'
                    )
                )->where(
                    'card', $card->id
                )->where(
                    'type', 1
                )->where(
                    'candidate', '<', 88
                )->groupBy(
                    'candidate'
                )->orderByDesc(
                    'votes'
                )->first();

            if ($mostVotedCandidate) {
                $candidate = DB::table('tbcandidates')->find(
                    $mostVotedCandidate->candidate
                );

                if ($candidate) {
                    $candidatesList[] = [
                        'id' => $candidate->id,
                        'name' => $candidate->name,
                        'votes' => $mostVotedCandidate->votes
                    ];
                }
            }

            $blankVotes = DB::table('tbvotings')->where(
                'card', $card->id
            )->where(
                'type', 1
            )->where(
                'candidate', 88
            )->count();

            $nullVotes = DB::table('tbvotings')->where(
                'card', $card->id
            )->where(
                'type', 1
            )->where(
                'candidate', 99
            )->count();

            $candidatesList[] = ['id' => 88, 'name' => 'Branco', 'votes' => $blankVotes];
            $candidatesList[] = ['id' => 99, 'name' => 'Nulo', 'votes' => $nullVotes];

            return (object) [
                'id' => $card->id,
                'title' => $card->title,
                'totalVotes' => array_sum(array_column($candidatesList, 'votes')),
                'candidatesList' => $candidatesList,
                'cardsNames' => $cardsNames
            ];
        });

        $election = DB::table('tbelections')->where(
            'type', 1
        )->first();

        $logo = DB::table('tbuploads')->where(
            'type', 'logo'
        )->first();

        $client = DB::table('tbassociation')->where(
            'id', 1
        )->first();

        if ($election->couting_token) {
            $coutingToken = $election->couting_token;
        } else {
            $coutingToken = $this->admGlobalController->generateTokenCode();

            DB::table('tbelections')->where(
                'type', 1
            )->update([
                'couting_token' => $coutingToken
            ]);
        }

        if (strpos($cardsNames, ',') !== false) {
            $lastCommaPos = strrpos($cardsNames, ',');
            $cardsNames = substr_replace($cardsNames, ' e ', $lastCommaPos, 2);
        }

        return view('adm/printElection', [
            'cards' => $cards,
            'election' => $election,
            'cardsNames' => $cardsNames,
            'coutingToken' => $coutingToken,
            'logo' => $logo,
            'client' => $client
        ]);
    }
    // Ação para imprimir a listagem dos eleitores participantes (Apuração > Eleitores)
    public function AdmPrintVoters() {
        $voters = DB::table('tbvotings as v')->join(
            'tbvoters as e', 'v.voter', '=', 'e.id'
        )->where(
            'e.status', 1
        )->distinct()->orderBy(
            'e.fullname', 'asc'
        )->get(
            [
                'v.voter', 'e.fullname', 'e.cpf', 'e.rg', 'e.other_doc'
            ]
        );

        $logo = DB::table('tbuploads')->where(
            'type', 'logo'
        )->first();

        $election = DB::table('tbelections')->where(
            'type', 1
        )->first();

        $client = DB::table('tbassociation')->where(
            'id', 1
        )->first();

        if ($election->voters_token) {
            $votersToken = $election->voters_token;
        } else {
            $votersToken = $this->admGlobalController->generateTokenCode();

            DB::table('tbelections')->where(
                'type', 1
            )->update([
                'voters_token' => $votersToken
            ]);
        }

        return view('adm/printVoters', [
            'voters' => $voters,
            'logo' => $logo,
            'election' => $election,
            'client' => $client,
            'votersToken' => $votersToken
        ]);
    }
}
