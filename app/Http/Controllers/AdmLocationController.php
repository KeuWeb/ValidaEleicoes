<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AdmValidateController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\AdmLocations;
use App\Models\AdmCatLocations;

class AdmLocationController extends Controller
{
    protected $admValidateController;

    public function __construct(AdmValidateController $admValidateController)
    {
        $this->admValidateController = $admValidateController;
    }
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
        $categories = DB::table('tbcategories')->orderBy(
            'title', 'ASC'
        )->where(
            'status', 1
        )->get();

        $catsLocations  = DB::table('tbcat_locations')->where(
            'location', $location->id
        )->pluck(
            'category'
        )->toArray();

        if (isset($catsLocations)) {
            if($catsLocations[0] == 0) {
                $catsLocation = collect([ (object) ['id' => 0, 'title' => "Todas as categorias"] ]);
            } else {
                $catsLocation = DB::table('tbcategories')->orderBy(
                    'title', 'ASC'
                )->whereIn(
                    'id', $catsLocations
                )->get();
            }
        }

        return view('adm/location', [
            'categories' => $categories,
            'location' => $location,
            'catsLocations' => $catsLocations,
            'catsLocation' => $catsLocation
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

            $catLocation->where('location', $request->id)->delete();

            $arr_categories = explode(',', $request->categories);

            for($c = 0;$c < count($arr_categories);$c++) {
                $catLocation->insert([
                    'category' => $arr_categories[$c],
                    'location' => $request->id,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            }

            $idLocation = $request->id;
        } else {
            if (!empty($request->local)) {
                $checkerLocal = $this->admValidateController->AdmCheckCadDo('tblocations', 'local', $request->local, 'localidade');

                if($checkerLocal) {
                    return $checkerLocal;
                }
            }

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
    // Ação para excluir o registro no BD
    public function AdmDelLocationDo(Request $request)
    {
        if (!empty($request)) {
            $location = new AdmLocations();

            $location->where(
                'id',$request->idDelete
            )->update([
                'status' => 2
            ]);

            $cats = new AdmCatLocations();

            $cats->where(
                'location', $request->idDelete
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
