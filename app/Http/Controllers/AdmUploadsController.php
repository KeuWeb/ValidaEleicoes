<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AdmValidateController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\AdmUploads;
use Illuminate\Support\Facades\Storage;

class AdmUploadsController extends Controller
{
    protected $admValidateController;

    public function __construct(AdmValidateController $admValidateController)
    {
        $this->AdmValidateController = $admValidateController;
    }
    // Ação para acessar a pagina com seu respectivo formulário
    public function AdmUploads()
    {
        $upload = DB::table('tbconfigs')->select()->first();

        return view('adm/uploads', [
            'link_logo' => $upload->link_logo,
            'link_doc' => $upload->link_doc
        ]);
    }
    // Ação para salvar o arquivo no BD
    public function AdmUploadsDo(Request $request)
    {
        $fileUpload = 'upload-'.$request->upload;

        if ($request->upload == "logo") {
            $type = 'jpeg,png,gif';
            $txtType = 'O arquivo deve ser um arquivo tipo imagem: jpeg, png ou gif.';
        } elseif ($request->upload == "doc") {
            $type = "doc,docx,pdf";
            $txtType = 'O arquivo deve ser um arquivo tipo texto: doc, docx ou pdf.';
        } elseif ($request->upload == "list") {
            $type = "csv";
            $txtType = 'O arquivo deve ser um arquivo tipo Excel: csv.';
        } else {
            return response()->json([
                'status' => "error",
                'message' => "Opção de upload inválida."
            ]);

            exit();
        }

        if ($request->hasFile($fileUpload)) {

            try {

                // $request->validate([
                //     $fileUpload => [
                //         'required',
                //         'file',
                //         'mimes:'.$type,
                //         'max:2048'
                //     ],
                // ], [
                //     $fileUpload.'.mimes' => $txtType,
                //     $fileUpload.'.max' => 'O arquivo não pode ter mais de 2MB.',
                // ]);

                $file = $request->file($fileUpload);

                if (is_array($file)) {
                    $file = $file[0];
                }

                if ($request->upload == "list") {
                    $csvValidationError = $this->AdmValidateController->AdmCsvDo($file);
                    if ($csvValidationError) {
                        return response()->json([
                            'status' => 'alert',
                            'message' => $csvValidationError,
                        ], 200);
                    }
                }

                $path = $file->store('upload');
                $hashName = $file->hashName();

                $uploads = new AdmUploads();

                $uploads->where(
                    'id',1
                    )->update([
                    'link_'.$request->upload => $path
                ]);

                return response()->json([
                    'status' => "success",
                    'message' => "Upload realizado com sucesso.",
                    'link' => $path
                ]);

                exit();
            } catch (\Illuminate\Validation\ValidationException $e) {
                $errorMessage = collect($e->errors())->flatten()->implode(' ');

                return response()->json([
                    'status' => 'alert',
                    'message' => $errorMessage,
                ], 200);
            }
        } else {
            return response()->json([
                'status' => 'alert',
                'message' => 'Ops! Arquivo não enviado.'
            ]);

            exit();
        }
    }
}

