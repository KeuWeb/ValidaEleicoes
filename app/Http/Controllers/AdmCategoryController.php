<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\AdmCategories;

class AdmCategoryController extends Controller
{
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

            $com = new AdmCategories();

            $com->insert([
                'title' => $request->title,
                'created_at' => date('Y-m-d h:i:s')
                ]);

            return response()->json([
                'status' => "success",
                'message' => "Dado salvo com sucesso."
            ]);

            exit(); 
        }
    }    
}
