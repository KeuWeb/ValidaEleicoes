<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AdmValidateController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\AdmCandidates;

class AdmCandidatesController extends Controller
{
    protected $admValidateController;

    public function __construct(AdmValidateController $admValidateController)
    {
        $this->admValidateController = $admValidateController;
    }
    // Ação para acessar a pagina do formulário para cadastro
    public function AdmCandidate()
    {
        $categories = DB::table('tbcategories')->orderBy(
            'title', 'ASC'
        )->where(
            'status', 1
        )->get();

        $locations = DB::table('tblocations')->orderBy(
            'local', 'ASC'
        )->where(
            'status', 1
        )->get();

        $configs = DB::table('tbconfigs')->first();

        return view('adm/candidate', [
            'categories' => $categories,
            'locations' => $locations,
            'configs' => $configs
        ]);
    }
    // Ação para efetuar a listagem dos cadastros feitos e busca, caso houver
    public function AdmCandidates(Request $request)
    {
        $search = $request->validate([
            'src' => 'nullable|string',
        ]);

        $query = DB::table('tbcandidates')->orderBy(
            'name', 'ASC'
        )->where(
            'status', 1
        );

        if ($search) {
            $query->where(
                'name','like','%'.$search['src'].'%'
            );
        }

        $candidates = $query->get();

        // dd($candidates);

        return view('adm/candidates', [
            'search' => $search,
            'candidates' => $candidates
        ]);
    }
    // Ação para direcionar para a pagina da edição do cadastro selecionado
    public function AdmEditCandidate(AdmCandidates $candidate)
    {
        $locations = DB::table('tblocations')->orderBy(
            'local', 'ASC'
        )->where(
            'status', 1
        )->get();

        $configs = DB::table('tbconfigs')->first();

        $categories = DB::table('tbcategories')->where(
            'id', $candidate->category
        )->get();

        if ($categories->isEmpty()) {
            $categories = collect([(object) ['id' => 0, 'title' => "Todas as categorias"]]);
        }

        $photo = DB::table('tbuploads')->where(
            'id', $candidate->photo
        )->first();

        $cards = DB::table('tbcards')->where(
            'category', $candidate->category
        )->where(
            'local', $candidate->local
        )->where(
            'status', 1
        )->get();

        return view('adm/candidate', [
            'categories' => $categories,
            'locations' => $locations,
            'cards' => $cards,
            'configs' => $configs,
            'candidate' => $candidate,
            'photo' => $photo
        ]);
    }
    // Ação para salvar os dados no BD
    public function AdmCandidateDo(Request $request)
    {
        if (!empty($request->form_category) && $request->form_category == 1) {
            if (empty($request->category_candidate) && $request->category_candidate != 0) {
                return response()->json([
                    'status' => "alert",
                    'message' => "Ops! Campo categoria deve ser preenchido."
                ]);

                exit();
            } else {
                $category = $request->category_candidate;
            }
        } else {
            $category = null;
        }

        $candidate = new AdmCandidates();

        if (!empty($request->id)) {
            $candidate->where(
                'id',$request->id
            )->update([
                'type' => $request->type,
                'name' => $request->name,
                'category' => $category,
                'local' => $request->local_candidate,
                'card' => $request->card_candidate,
                'photo' => $request->id_photo,
                'curriculum' => $request->curriculum,
                'obs' => $request->obs

            ]);

            $idCandidate = $request->id;
        } else {
            if (!empty($request->name)) {
                $checkerName = $this->admValidateController->AdmCheckCadDo('tbcandidates', 'name', $request->name, 'nome');

                if($checkerName) {
                    return $checkerName;
                }
            }

            $candidate->insert([
                'type' => $request->type,
                'name' => $request->name,
                'category' => $category,
                'local' => $request->local_candidate,
                'card' => $request->card_candidate,
                'photo' => $request->id_photo,
                'curriculum' => $request->curriculum,
                'obs' => $request->obs
            ]);

            $idCandidate = $candidate->latest()->first()->id;
        }

        return response()->json([
            'status' => "success",
            'message' => "Dados salvos com sucesso.",
            'id' => $idCandidate
        ]);

        exit();
    }
}
