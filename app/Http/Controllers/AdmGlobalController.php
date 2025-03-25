<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Jenssegers\Agent\Agent;
use App\Services\EmailService;
use Illuminate\Support\Facades\Log;

class AdmGlobalController extends Controller
{
    // Ação para litagem das categorias conforme local selecionado
    public function AdmCategoriesListDo(Request $request) {
        $location = $request->location;

        $categories = collect(DB::table('tbcat_locations')->join(
            'tbcategories', 'tbcat_locations.category', '=', 'tbcategories.id'
        )->where(
            'tbcat_locations.status', 1
        )->where(
            'tbcategories.status', 1
        )->where(
            'tbcat_locations.location', $location
        )->distinct(
            'tbcat_locations.category'
        )->orderBy(
            'tbcategories.title', 'ASC'
        )->select(
            'tbcat_locations.category', 'tbcategories.title'
        )->get());

        if ($categories->isNotEmpty()) {
            $html = "<option value=''>Selecione a categoria</option>";

            foreach ($categories as $category) {
                $html .= "<option value='" . $category->category . "'>" . $category->title . "</option>";
            }
        } else {
            $html = "<option value=''>Selecione a categoria</option><option value='0'>Todas as categorias.</option>";
        }

        return response()->json([
            'status' => 'success',
            'html' => $html
        ]);

        exit();
    }
    // Ação para listagem das cédulas conforme local e categoria selecionada
    public function AdmCardsListDo(Request $request) {
        $location = $request->location;
        $category = $request->category;

        $cards = DB::table('tbcards')->where(
            'category', $category
        )->where(
            'local', $location
        )->where(
            'status', 1
        )->orderBy(
            'title', 'ASC'
        )->get();

        if ($cards->isNotEmpty()) {
            $html = "<option value=''>Selecione a cédula</option>";

            foreach ($cards as $card) {
                $html .= "<option value='" . $card->id . "'>" . $card->title . "</option>";
            }
        } else {
            return response()->json([
                'status' => 'alert',
                'html' => 'Não há cédulas com a Localidade e Categoria selecionada'
            ]);
        }

        return response()->json([
            'status' => 'success',
            'html' => $html
        ]);

        exit();
    }
    // Ação para capturar os dados de acesso do eleitor (indicação e eleição)
    public function getUserInfo(Request $request)
    {
        $agent = new Agent();

        $ip = $request->ip();
        $device = $agent->device() ?: 'Desconhecido';
        $browser = $agent->browser() ?: 'Desconhecido';
        $os = $agent->platform() ?: 'Desconhecido';
        $viaMobile = $agent->isMobile() ? 'Sim' : 'Não';

        return "IP: $ip; Device: $device; Browser: $browser; O.S.: $os; Via Mobile: $viaMobile.";
    }
    // Função para geração de chave token de validação de indicação e eleição
    public function generateTokenCode($length = 8) {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $code = '';

        for ($i = 0; $i < $length; $i++) {
            $code .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $code;
    }
    // Ação para validação das indicações
    public function promoteCandidates()
    {
        $indications = DB::table('tbcandidates')->where(
            'type', 0
        )->select(
            'id', 'card', 'votes_indication'
        )->orderByDesc(
            'votes_indication'
        )->get();

        $candidatesPerCard = [];

        foreach ($indications as $indication) {
            $cardId = $indication->card;

            if (!isset($candidatesPerCard[$cardId])) {
                $limitCandidates = DB::table('tbcards')->where(
                    'id', $cardId
                )->value('limit_indicates');

                $candidatesPerCard[$cardId] = [
                    'limit' => $limitCandidates,
                    'count' => DB::table('tbcandidates')->where(
                        'card', $cardId
                    )->where(
                        'type', 1
                    )->count()
                ];
            }

            if ($candidatesPerCard[$cardId]['count'] >= $candidatesPerCard[$cardId]['limit']) {
                continue;
            }

            $candidatesForCard = $this->getCandidatesForCard($indications, $cardId);

            foreach ($candidatesForCard as $candidate) {
                $remainingSlots = $candidatesPerCard[$cardId]['limit'] - $candidatesPerCard[$cardId]['count'];

                if ($remainingSlots > 1) {
                    DB::table('tbcandidates')->where(
                        'id', $candidate->id
                    )->update([
                        'type' => 1
                    ]);

                    $candidatesPerCard[$cardId]['count']++;
                } elseif ($remainingSlots == 1) {
                    $notPromoted = array_filter($candidatesForCard, function ($c) {
                        return DB::table('tbcandidates')->where(
                            'id', $c->id
                        )->value('type') == 0;
                    });

                    if ($this->isTie($notPromoted, $remainingSlots)) {
                        $this->handleManualTie($cardId);
                        break;
                    } else {
                        DB::table('tbcandidates')->where(
                            'id', reset($notPromoted)->id
                        )->update([
                            'type' => 1
                        ]);

                        $candidatesPerCard[$cardId]['count']++;
                    }
                }

                // ✅ Se atingiu o limite, muda o status do card
                if ($candidatesPerCard[$cardId]['count'] >= $candidatesPerCard[$cardId]['limit']) {
                    DB::table('tbcards')->where(
                        'id', $cardId
                    )->update([
                        'status_voting' => 1
                    ]);

                    DB::table('tbcandidates')->where(
                        'card', $cardId
                    )->where(
                        'type', 0
                    )->update([
                        'type' => 3
                    ]);
                }
            }
        }
    }
    // Obtém os candidatos de uma cédula ordenados pelo número de votos.
    private function getCandidatesForCard($indications, $cardId)
    {
        $candidates = [];

        foreach ($indications as $indication) {
            if ($indication->card == $cardId) {
                $candidates[] = $indication;
            }
        }

        usort($candidates, function ($a, $b) {
            return $b->votes_indication <=> $a->votes_indication;
        });

        return $candidates;
    }
    // Verifica se há empate entre os candidatos restantes.
    private function isTie($candidates, $remainingSlots)
    {
        if (count($candidates) <= $remainingSlots) {
            return false;
        }

        $votes = array_map(fn($c) => $c->votes_indication, $candidates);
        return count(array_unique($votes)) === 1;
    }
    // Define o status da cédula como "empate" caso haja necessidade de decisão manual.
    private function handleManualTie($cardId)
    {
        DB::table('tbcards')->where(
            'id', $cardId
        )->update([
            'status_voting' => 2
        ]);
    }
}
