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
                'name', 'ASC'
            )->where(
                'status', 1
            );

        if ($search) {
            $query->where(
                'name','like','%'.$search['src'].'%'
            );
        }
    
        $voters = $query->get();
    
        return view('adm/voters', [
            'search' => $search,
            'voters' => $voters
        ]);
    }
    // Ação para verificar a força da senha digitada
    public function AdmPasswordDo(Request $request)
    {
        $local = base_path('public/inc/file/function.php');

        include $local;

        $checker = forcePassword($request->password);

        if ($checker == 4) {
            return response()->json([
                'status' => 'success',
                'width' => "100",
                'bgcolor' => "bg-success",
                'txt' => "senha forte"
            ]);

            exit();
        } else if($checker == 3) {
            return response()->json([
                'status' => 'success',
                'width' => "75",
                'bgcolor' => "bg-warning",
                'txt' => "senha moderada"
            ]);

            exit();
        } else if($checker == 2) {
            return response()->json([
                'status' => 'success',
                'width' => "50",
                'bgcolor' => "bg-warning",
                'txt' => "senha moderada"
            ]);

            exit();
        } else {
            return response()->json([
                'status' => 'success',
                'width' => "25",
                'bgcolor' => "bg-danger",
                'txt' => "senha fraca"
            ]);

            exit();
        }
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

        // dd(get_class($categories));

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
        if (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            return response()->json([
                'status' => "alert",
                'message' => "Ops! E-mail digitado inválido."
            ]);
    
            exit();
        }
        
        if (!empty($request->rg)) {
            if (!preg_match('/(^\d{1,2}).?(\d{3}).?(\d{3})-?(\d{1}|X|x$)/', $request->rg)) {
                return response()->json([
                    'status' => "alert",
                    'message' => "Ops! RG digitado inválido."
                ]);

                exit();               
            }
        }

        if (!preg_match('/(^\d{3}\.\d{3}\.\d{3}\-\d{2}$)/', $request->cpf)) {
            return response()->json([
                'status' => "alert",
                'message' => "Ops! CPF digitado inválido."
            ]);

            exit();               
        }

        $voter = new AdmVoters();

        if (!empty($request->id)) {  
            if (empty($request->password)) {
                $voter->where(
                    'id',$request->id
                )->update([
                    'fullname' => $request->fullname,
                    'rg' => $request->email,
                    'cpf' => $request->phone,
                    'other_doc' => $request->login,
                    'email' => $request->level,
                    'category' => $request->category,
                    'local' => $request->local,
                    'password' => Hash::make($request->password)
                ]);
            } else {
                $voter->where(
                    'id',$request->id
                )->update([
                    'fullname' => $request->fullname,
                    'rg' => $request->email,
                    'cpf' => $request->phone,
                    'other_doc' => $request->login,
                    'email' => $request->level,
                    'category' => $request->category,
                    'local' => $request->local
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
                    'rg' => $request->email,
                    'cpf' => $request->phone,
                    'other_doc' => $request->login,
                    'email' => $request->level,
                    'category' => $request->category,
                    'local' => $request->local,
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
