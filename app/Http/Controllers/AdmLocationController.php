<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\AdmLocations;
use App\Models\AdmCatLocations;

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
    // Ação para direcionar para a pagina da edição do cadastro selecionado
    public function AdmEditLocation(AdmLocations $location)
    {
        return view('adm/location', [
            'location' => $location
        ]);
    }
    // Ação para cadastrar os dados no Banco de Dados
    public function AdmLocationDo(Request $request)
    {
        if (empty($request->categories) && $request->categories != 0) {
            return response()->json([
               'status' => "alert",
               'message' => "Ops! Não há categoria(s) selecionada(s)."
            ]);

            exit();
        }

        $location = new AdmLocations();
        $catLocation = new AdmCatLocations();

        $cadVerify = $location->where(
                'local', $request->local
            )->where(
                'category', $request->categories
            )->where(
                'status', 1
            );

        if(!isset($cadVerify)) {
            return response()->json([
                'status' => "alert",
                'message' => "Ops! Localidade já cadastrada."
             ]);
 
             exit();
        }

        if (!empty($request->id)) {
            $location->where('id', $request->id)->update([
                'local' => $request->local
            ]);

            $catLocation->where('category', $request->id)->delete();

            $arr_categories = explode(',', $request->categories);

            for($c = 0;$c < count($arr_categories);$c++) {
                $catLocation->insert([
                    'location' => $arr_categories[$c],
                    'category' => $request->id
                ]);
            }

            $idLocation = $request->id;
        } else {
            $location->insert([
                'local' => $request->local,
                'created_at' => date('Y-m-d H:i:s')
            ]);

            $arr_categories = explode(',', $request->categories);
            $idLocation = $location->latest()->first()->id;

            for($c = 0;$c < count($arr_categories);$c++) {
                $catLocation->insert([
                    'location' => $idLocation,
                    'category' => $arr_categories[$c],
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            }            
        }

        return response()->json([
            'status' => "success",
            'message' => "Dados salvos com sucesso."
        ]);

        exit();
    }
}
