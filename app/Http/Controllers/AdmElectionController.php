<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\AdmElection;
use App\Models\AdmCards;
use App\Http\Controllers\AdmGlobalController;


class AdmElectionController extends Controller
{
    protected $admGlobalController;

    public function __construct(AdmGlobalController $admGlobalController)
    {
        $this->admGlobalController = $admGlobalController;
    }
    // Ação para visualizar apagina bem como seus respectivos dados
    public function AdmElection()
    {
        $type = DB::table('tbconfigs')->select(
            'type','form_aval'
        )->first();

        $indication = DB::table('tbelections')->where(
            'type', 0
        )->first();

        $election = DB::table('tbelections')->where(
            'type', 1
        )->first();

        return view('adm/election', [
            'type' => $type,
            'indication' => $indication,
            'election' => $election
        ]);
    }
    // Ação para salvar os dados no BD
    public function AdmElectionDo(Request $request)
    {
        $election = new AdmElection();

        if (!empty($request->indication)) {
            $request->validate([
                'titleInd'=> 'required|string',
                'dateIniInd' => 'required|date',
                'hourIniInd' => 'required',
                'dateEndInd' => 'required|date',
                'hourEndInd' => 'required'
            ]);

            $dateIniIndComplete = strtotime($request->dateIniInd . ' ' . $request->hourIniInd);
            $dateEndIndComplete = strtotime($request->dateEndInd . ' ' . $request->hourEndInd);

            if ($dateIniIndComplete < strtotime('now')) {
                return response()->json([
                    'status' => "alert",
                    'message' => "Ops! A data inicial da indicação não pode ser anterior à data atual.",
                    'dados' => date('Y-m-d H:i:s', $dateIniIndComplete) . " - " . date('Y-m-d H:i:s', strtotime('now'))
                ]);

                exit();
            }

            if ($dateEndIndComplete < strtotime('now')) {
                return response()->json([
                    'status' => "alert",
                    'message' => "Ops! A data final da indicação não pode ser anterior à data atual."
                ]);

                exit();
            }

            if (!empty($request->dateInvInd)) {
                $request->validate([
                    'dateInvInd' => 'required|date'
                ]);

                $dateInvIndComplete = strtotime($request->dateInvInd . ' ' . $request->hourInvInd);

                if ($dateInvIndComplete < strtotime('now')) {
                    return response()->json([
                        'status' => "alert",
                        'message' => "Ops! A data da apuração da indicação não pode ser anterior à data atual."
                    ]);

                    exit();
                }

                if ($dateIniIndComplete > $dateInvIndComplete) {
                    return response()->json([
                        'status' => "alert",
                        'message' => "Ops! Intervalo das datas da indicação (data inicial e data apuração) está incorreta."
                    ]);

                    exit();
                }

                if ($dateEndIndComplete > $dateInvIndComplete) {
                    return response()->json([
                        'status' => "alert",
                        'message' => "Ops! Intervalo das datas da indicação (data final e data apuração) está incorreta."
                    ]);

                    exit();
                }
            }

            if ($dateIniIndComplete > $dateEndIndComplete) {
                return response()->json([
                    'status' => "alert",
                    'message' => "Ops! Intervalo das datas da indicação (data inicial e data final) está incorreta."
                ]);

                exit();
            }

            if (strtotime($request->dateIniInd) > strtotime($request->dateIniEle) || strtotime($request->dateIniInd) > strtotime($request->dateEndEle) || strtotime($request->dateEndInd) > strtotime($request->dateIniEle) || strtotime($request->dateEndInd) > strtotime($request->dateEndEle) || strtotime($request->dateIniInd) > strtotime($request->dateInvEle) || strtotime($request->dateEndInd) > strtotime($request->dateInvEle)) {
                return response()->json([
                    'status' => "alert",
                    'message' => "Ops! A(s) data(s) de indicação não pode ser após a(s) data(s) da eleição."
                ]);

                exit();
            }

            if (strtotime($request->dateInvEle) < strtotime($request->dateIniInd) || strtotime($request->dateInvEle) < strtotime($request->dateEndInd)) {
                return response()->json([
                    'status' => "alert",
                    'message' => "Ops! Data da indicação não pode ser anterior à data da eleição."
                ]);

                exit();
            }

            if (!empty($request->idIndication)) {
                if (!empty($request->dateInvInd)) {
                    $election->where(
                        'id',$request->idIndication
                    )->update([
                        'title' => $request->titleInd,
                        'date_initial' => $request->dateIniInd,
                        'hour_initial' => $request->hourIniInd,
                        'date_end' => $request->dateEndInd,
                        'hour_end' => $request->hourEndInd,
                        'date_invite' => $request->dateInvInd,
                        'hour_invite' => $request->hourInvInd
                    ]);
                } else {
                    $election->where(
                        'id',$request->idIndication
                    )->update([
                        'title' => $request->titleInd,
                        'date_initial' => $request->dateIniInd,
                        'hour_initial' => $request->hourIniInd,
                        'date_end' => $request->dateEndInd,
                        'hour_end' => $request->hourEndInd,
                        'date_invite' => null,
                        'hour_invite' => null
                    ]);
                }

                $idIndication = $request->idIndication;
            } else {
                if (!empty($request->dateInvInd)) {
                    $election->insert([
                        'type' => $request->indication,
                        'title' => $request->titleInd,
                        'date_initial' => $request->dateIniInd,
                        'hour_initial' => $request->hourIniInd,
                        'date_end' => $request->dateEndInd,
                        'hour_end' => $request->hourEndInd,
                        'date_invite' => $request->dateInvInd,
                        'hour_invite' => $request->hourInvInd,
                        'created_at' => date('Y-m-d h:i:s')
                    ]);
                } else {
                    $election->insert([
                        'type' => $request->indication,
                        'title' => $request->titleInd,
                        'date_initial' => $request->dateIniInd,
                        'hour_initial' => $request->hourIniInd,
                        'date_end' => $request->dateEndInd,
                        'hour_end' => $request->hourEndInd,
                        'date_invite' => null,
                        'hour_invite' => null,
                        'created_at' => date('Y-m-d h:i:s')
                    ]);
                }

                $idIndication = DB::getPdo()->lastInsertId();
            }
        } else {
            $idIndication = null;
        }

        $request->validate([
            'titleEle'=> 'required|string',
            'dateIniEle' => 'required|date',
            'hourIniEle' => 'required|',
            'dateEndEle' => 'required|date',
            'hourEndEle' => 'required',
            'dateInvEle' => 'required|date',
            'hourInvEle' => 'required'
        ]);

        $dateIniEleComplete = strtotime($request->dateIniEle . ' ' . $request->hourIniEle);
        $dateEndEleComplete = strtotime($request->dateEndEle . ' ' . $request->hourEndEle);
        $dateInvEleComplete = strtotime($request->dateInvEle . ' ' . $request->hourInvEle);

        if ($dateIniEleComplete < strtotime('now')) {
            return response()->json([
                'status' => "alert",
                'message' => "Ops! A data inicial da eleição não pode ser anterior à data atual.",
                'idInd' => $idIndication
            ]);

            exit();
        }

        if ($dateEndEleComplete < strtotime('now')) {
            return response()->json([
                'status' => "alert",
                'message' => "Ops! A data final da eleição não pode ser anterior à data atual.",
                'idInd' => $idIndication
            ]);

            exit();
        }

        if ($dateInvEleComplete < strtotime('now')) {
            return response()->json([
                'status' => "alert",
                'message' => "Ops! A data apuração da eleição não pode ser anterior à data atual.",
                'idInd' => $idIndication
            ]);

            exit();
        }

        if ($dateIniEleComplete > $dateEndEleComplete) {
            return response()->json([
                'status' => "alert",
                'message' => "Ops! Intervalo das datas da eleição (data inicial e data final) está incorreta.",
                'idInd' => $idIndication
            ]);

            exit();
        }

        if ($dateIniEleComplete > $dateInvEleComplete) {
            return response()->json([
                'status' => "alert",
                'message' => "Ops! Intervalo das datas da eleição (data incial e data apuração) está incorreta.",
                'idInd' => $idIndication
            ]);

            exit();
        }

        if ($dateEndEleComplete > $dateInvEleComplete) {
            return response()->json([
                'status' => "alert",
                'message' => "Ops! Intervalo das datas da eleição (data final e data apuração) está incorreta.",
                'idInd' => $idIndication
            ]);

            exit();
        }

        if (!empty($request->idElection)) {
            $election->where(
                'id', $request->idElection
            )->update([
                'title' => $request->titleEle,
                'date_initial' => $request->dateIniEle,
                'hour_initial' => $request->hourIniEle,
                'date_end' => $request->dateEndEle,
                'hour_end' => $request->hourEndEle,
                'date_invite' => $request->dateInvEle,
                'hour_invite' => $request->hourInvEle

            ]);

            $idElection = $request->idElection;
        } else {
            $election->insert([
                'type' => $request->election,
                'title' => $request->titleEle,
                'date_initial' => $request->dateIniEle,
                'hour_initial' => $request->hourIniEle,
                'date_end' => $request->dateEndEle,
                'hour_end' => $request->hourEndEle,
                'date_invite' => $request->dateInvEle,
                'hour_invite' => $request->hourInvEle,
                'created_at' => date('Y-m-d h:i:s')
            ]);

            $idElection = DB::getPdo()->lastInsertId();
        }

        return response()->json([
            'status' => "success",
            'message' => "Dados salvos com sucesso.",
            'idInd' => $idIndication,
            'idEle' => $idElection
        ]);

        exit();
    }
}
