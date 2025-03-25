<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AdmValidateController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\AdmCategories;

class AdmCategoryController extends Controller
{
    protected $admValidateController;

    public function __construct(AdmValidateController $admValidateController)
    {
        $this->admValidateController = $admValidateController;
    }
    // Requisição para acessar a pagina do modulo
    public function AdmCategory() {
        return view('adm/category');
    }
    // Ação para efetuar a listagem dos cadastros feitos e busca, caso houver
    public function AdmCategories(Request $request)
    {
        $search = $request->validate([
            'src' => 'nullable|string',
        ]);

        $query = DB::table('tbcategories')->orderBy(
                'title', 'ASC'
            )->where(
                'status', 1
            );

        if ($search) {
            $query->where(
                'title','like','%'.$search['src'].'%'
            );
        }

        $categories = $query->get();

        return view('adm/categories', [
            'search' => $search,
            'categories' => $categories
        ]);
    }
    // Ação para direcionar para a pagina da edição do cadastro selecionado
    public function AdmEditCategory(AdmCategories $category)
    {
        return view('adm/category', [
            'category' => $category
        ]);
    }
    // Requisição para efetuar a gravação dos dados editados no BD
    public function AdmCategoryDo(Request $request)
    {
        if (!isset($request)) {
            return response()->json([
                'status' => "alert",
                'message' => "Ops! Há campo(s) em branco."
            ]);

            exit();
        }else{
            $request->validate([
                'title' => 'required|string'
            ]);

            $cat = new AdmCategories();

            if (!empty($request->id)) {
                $cat->where(
                    'id',$request->id
                )->update([
                    'title' => $request->title
                ]);

                $idCategory = $request->id;
            } else {
                if (!empty($request->title)) {
                    $checkerTitle = $this->admValidateController->AdmCheckCadDo('tbcategories', 'title', $request->title, 'titulo');

                    if($checkerTitle) {
                        return $checkerTitle;
                    }
                }

                $cat->insert([
                    'title' => $request->title,
                    'created_at' => date('Y-m-d h:i:s')
                ]);

                $idCategory = $cat->latest()->first()->id;
            }

            return response()->json([
                'status' => "success",
                'message' => "Dado salvo com sucesso.",
                'id' => $idCategory
            ]);

            exit();
        }
    }
        // Ação para excluir o registro no BD
        public function AdmDelCategoryDo(Request $request)
        {
            if (!empty($request)) {
                $category = new AdmCategories();

                $category->where(
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
