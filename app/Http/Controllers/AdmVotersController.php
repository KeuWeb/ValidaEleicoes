<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AdmValidateController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\AdmVoters;

class AdmVotersController extends Controller
{
    protected $admValidateController;

    public function __construct(AdmValidateController $admValidateController)
    {
        $this->admValidateController = $admValidateController;
    }
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
        ]);
    }
    // Ação para acessar a pagina de importação de cadastros
    public function AdmImportVoters() {
        $import = DB::table('tbuploads')->where(
            'type', 'list'
            )->first();

        return view('adm/import', [
            'import' => $import
        ]);
    }
    // Ação para direcionar para a pagina da edição do cadastro selecionado
    public function AdmEditVoter(AdmVoters $voter, $local)
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

        if($categories->isEmpty()) {
            $categories = collect([ (object) ['id' => 0, 'title' => "Todas as categorias"] ]);
        } else {
            $categories = $categories;
        }

        $locations = DB::table('tblocations')->orderBy(
            'local', 'ASC'
        )->where(
            'status', 1
        )->get();

        $configs = DB::table('tbconfigs')->first();

        return view('adm/voter', [
            'categories' => $categories,
            'locations' => $locations,
            'configs' => $configs,
            'voter' => $voter
        ]);
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

    // Ação para salvar os dados no BD
    public function AdmVoterDo(Request $request)
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

        $voter = new AdmVoters();

        if (!empty($request->id)) {
            if (!empty($request->password)) {
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
                    'other_login' => $request->other_login,
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
                    'local' => $request->local_voter,
                    'other_login' => $request->other_login
                ]);
            }

            $idVoter = $request->id;
        } else {
            if (!empty($request->rg)) {
                $checkerRG = $this->admValidateController->AdmCheckCadDo('tbvoters', 'rg', $request->rg, 'rg');

                if($checkerRG) {
                    return $checkerRG;
                }
            }

            if (!empty($request->cpf)) {
                $checkerCPF = $this->admValidateController->AdmCheckCadDo('tbvoters', 'cpf', $request->cpf, 'cpf');

                if($checkerCPF) {
                    return $checkerCPF;
                }
            }

            if (!empty($request->email)) {
                $checkerEmail = $this->admValidateController->AdmCheckCadDo('tbvoters', 'email', $request->email, 'e-mail');

                if($checkerEmail) {
                    return $checkerEmail;
                }
            }

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
                    'local' => $request->local_voter,
                    'category' => $request->category,
                    'other_login' => $request->other_login,
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
    // Ação para excluir o registro no BD
    public function AdmDelVoterDo(Request $request)
    {
        if (!empty($request)) {
            $voter = new AdmVoters();

            $voter->where(
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
