<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\AdmLocations;

class AdmLocationController extends Controller
{
    // Ação para acessar a pagina do formulário para cadastro
    public function AdmLocation()
    {
        $categories = DB::table('tbcategories')->orderBy(
                'title', 'ASC'
            )->where(
                'status', 1
            )->get();
      
        return view('adm/location', [
            'categories' => $categories
        ]);
    }
    // Ação para efetuar a listagem dos cadastros feitos e busca, caso houver 
    public function AdmLocations(Request $request)
    {    
        $search = $request->validate([
            'src' => 'nullable|string',
        ]);

        $query = DB::table('tblocations')->orderBy(
                'local', 'ASC'
            )->where(
                'status', 1
            );

        if ($search) {
            $query->where(
                'local','like','%'.$search['src'].'%'
            );
        }

        $locations = $query->get();

        return view('adm/locations', [
            'search' => $search,
            'locations' => $locations
        ]);
    }
}
