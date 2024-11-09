<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\AdmVoters;

class AdmVotersController extends Controller
{
    // Ação para acessar a pagina do formulário para cadastro
    public function AdmVoter()
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

        return view('adm/voter', [
            'categories' => $categories,
            'locations' => $locations,
            'configs' => $configs
        ]);;
    }
    // Ação para acessar a pagina do formulário para cadastro
    public function AdmVoters(Request $request)
    {
        $search = $request->validate([
            'src' => 'nullable|string',
        ]);

        $query = DB::table('tbvoters')->orderBy(
                'fullname', 'ASC'
            )->where(
                'status', 1
            );

        if ($search) {
            $query->where(
                'fullname','like','%'.$search['src'].'%'
            );
        }
    
        $voters = $query->get();
    
        return view('adm/voters', [
            'search' => $search,
            'voters' => $voters
        ]);
    }
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
            $html = "";

            foreach ($categories as $category) {
                $html .= "<option value='" . $category->category . "'>" . $category->title . "</option>";
            }
        } else {
            $html = "<option value='0'>Todas as categorias.</option>";
        }

        return response()->json([
            'status' => 'success',
            'html' => $html
        ]);

        exit();
    }
    // Ação para salvar os dados no BD
    public function AdmVoterDo(Request $request)
    {
        if (!empty($request->form_category) && $request->form_category == 1) {
            if (empty($request->category)) {
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

        $voter = new AdmVoters();

        if (!empty($request->id)) {  
            if (empty($request->password)) {
                $voter->where(
                    'id',$request->id
                )->update([
                    'fullname' => $request->fullname,
                    'rg' => $request->rg,
                    'cpf' => $request->cpf,
                    'other_doc' => $request->other_doc,
                    'email' => $request->email,
                    'category' => $category,
                    'local' => $request->local_voter,
                    'password' => Hash::make($request->password)
                ]);
            } else {
                $voter->where(
                    'id',$request->id
                )->update([
                    'fullname' => $request->fullname,
                    'rg' => $request->rg,
                    'cpf' => $request->cpf,
                    'other_doc' => $request->other_doc,
                    'email' => $request->email,
                    'category' => $category,
                    'local' => $request->local_voter
                ]);
            }    
            
            $idVoter = $request->id;
        } else {
            if (empty($request->password)) {
                return response()->json([
                    'status' => "alert",
                    'message' => "Ops! Preencher o campo senha."
                ]);
        
                exit();
            } else {
                $voter->insert([
                    'fullname' => $request->fullname,
                    'rg' => $request->rg,
                    'cpf' => $request->cpf,
                    'other_doc' => $request->other_doc,
                    'email' => $request->email,
                    'category' => $request->category,
                    'local' => $request->local_voter,
                    'password' => Hash::make($request->password),
                    'created_at' => date('Y-m-d H:i:s')            
                ]);

                $idVoter = $voter->latest()->first()->id;
            }
        }

        return response()->json([
            'status' => "success",
            'message' => "Dados salvos com sucesso.",
            'id' => $idVoter
        ]);

        exit();
    }
}
