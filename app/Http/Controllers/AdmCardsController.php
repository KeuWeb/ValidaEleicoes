<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AdmValidateController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\AdmCards;

class AdmCardsController extends Controller
{
    protected $admValidateController;

    public function __construct(AdmValidateController $admValidateController)
    {
        $this->admValidateController = $admValidateController;
    }
    // Ação para acessar a pagina do formulário para cadastro
    public function AdmCard()
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

        return view('adm/card', [
            'categories' => $categories,
            'locations' => $locations,
            'configs' => $configs
        ]);
    }
    // Ação para efetuar a listagem dos cadastros feitos e busca, caso houver
    public function AdmCards(Request $request)
    {
        $search = $request->validate([
            'src' => 'nullable|string',
        ]);

        $query = AdmCards::with(['location' => function ($query) {
            $query->select('id', 'local');
        }])
            ->select('id', 'title', 'local')
            ->where('status', 1);

        if (!empty($search['src'])) {
            $query->where(
                'title', 'like', '%' . $search['src'] . '%'
            );
        }

        $cards = $query->get();

        return view('adm/cards', [
            'search' => $search,
            'cards' => $cards,
        ]);
    }
    // Ação para direcionar para a pagina da edição do cadastro selecionado
    public function AdmEditCard(AdmCards $card, $local)
    {
        $categories = collect(DB::table('tbcat_locations')->join(
            'tbcategories', 'tbcat_locations.category', '=', 'tbcategories.id'
        )->where(
            'tbcat_locations.status', 1
        )->where(
            'tbcategories.status', 1
        )->where(
            'tbcat_locations.location', $local
        )->distinct(
            'tbcat_locations.category'
        )->orderBy(
            'tbcategories.title', 'ASC'
        )->select(
            'tbcat_locations.category', 'tbcategories.title', 'tbcategories.id'
        )->get());

        $locations = DB::table('tblocations')->orderBy(
            'local', 'ASC'
        )->where(
            'status', 1
        )->get();

        $configs = DB::table('tbconfigs')->first();

        if ($categories->isEmpty()) {
            $categories = collect([(object) ['id' => 0, 'title' => "Todas as categorias"]]);
        }

        return view('adm/card', [
            'categories' => $categories,
            'locations' => $locations,
            'configs' => $configs,
            'card' => $card
        ]);
    }
    // Ação para salvar os dados no BD
    public function AdmCardDo(Request $request)
    {
        if (!empty($request->form_category) && $request->form_category == 1) {
            if (empty($request->category) && $request->category != 0) {
                return response()->json([
                    'status' => "alert",
                    'message' => "Ops! Campo categoria deve ser preenchido."
                ]);

                exit();
            } else {
                $category = $request->category;
            }
        } else {
            $category = null;
        }

        $card = new AdmCards();

        if (!empty($request->id)) {
            $card->where(
                'id',$request->id
            )->update([
                'order' => $request->order,
                'title' => $request->title,
                'limit_votes' => $request->limit_votes,
                'limit_indicates' => $request->limit_indicates,
                'category' => $request->category,
                'local' => $request->local_card
            ]);

            $idCard = $request->id;
        } else {
            if (!empty($request->title)) {
                $checkerTitle = $this->admValidateController->AdmCheckCadDo('tbcards', 'title', $request->title, 'titulo', $request->local);

                if($checkerTitle) {
                    return $checkerTitle;
                }
            }

            if (!empty($request->order)) {
                $checkerLocal = $this->admValidateController->AdmCheckCadDo('tbcards', 'order', $request->order, 'ordem', $request->local);

                if($checkerLocal) {
                    return $checkerLocal;
                }
            }

            $card->insert([
                'order' => $request->order,
                'title' => $request->title,
                'limit_votes' => $request->limit_votes,
                'limit_indicates' => $request->limit_indicates,
                'category' => $request->category,
                'local' => $request->local_card,
                'created_at' => date('Y-m-d H:i:s')
            ]);

            $idCard = $card->latest()->first()->id;
        }

        return response()->json([
            'status' => "success",
            'message' => "Dados salvos com sucesso.",
            'id' => $idCard
        ]);

        exit();
    }
    // Ação para excluir o registro no BD
    public function AdmDelCardDo(Request $request)
    {
        if (!empty($request)) {
            $card = new AdmCards();

            $card->where(
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
