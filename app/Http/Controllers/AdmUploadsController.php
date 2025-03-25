<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AdmValidateController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\AdmUploads;
use App\Models\AdmCandidates;
use Illuminate\Support\Facades\Storage;

class AdmUploadsController extends Controller
{
    protected AdmValidateController $admValidateController;

    public function __construct(AdmValidateController $admValidateController)
    {
        $this->admValidateController = $admValidateController;
    }
    // Ação para acessar a pagina com seu respectivo formulário
    public function AdmUploads()
    {
        $upload = DB::table('tbuploads')->whereIn(
            'type', [
                'logo', 'doc'
            ]
        )->get();

        $logo = $upload->where(
            'type','logo'
        )->first();

        $doc = $upload->where(
            'type','doc'
        )->first();

        return view('adm/uploads', [
            'logo' => $logo,
            'doc' => $doc
        ]);
    }
    // Ação para salvar o arquivo no BD
    public function AdmUploadsDo(Request $request)
    {
        $fileUpload = 'upload-'.$request->upload;

        if ($request->upload == "logo") {
            $type = 'jpeg,png,gif';
            $txtType = 'O arquivo deve ser um arquivo tipo imagem: jpeg, png ou gif.';
            $pathFile = "image";
        }elseif ($request->upload == "photo") {
            $type = 'jpeg,png,gif';
            $txtType = 'O arquivo deve ser um arquivo tipo imagem: jpeg, png ou gif.';
            $pathFile = "photo";
        } elseif ($request->upload == "doc") {
            $type = "doc,docx,pdf";
            $txtType = 'O arquivo deve ser um arquivo tipo texto: doc, docx ou pdf.';
            $pathFile = "doc";
        } elseif ($request->upload == "list") {
            $type = "csv";
            $txtType = 'O arquivo deve ser um arquivo tipo Excel: csv.';
            $pathFile = "doc";
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

                $path = $file->store($pathFile);
                $hashName = $file->hashName();

                $uploads = new AdmUploads();

                $inputId = 'id_upload_' . $request->upload;

                if (empty($request->$inputId)) {
                    $uploads->insert([
                        'type' => $request->upload,
                        'name' => $hashName,
                        'link' => $path
                    ]);

                    $idUpload = $uploads->latest()->first()->id;
                } else {
                    $oldFile = $uploads->where(
                        'id',$request->$inputId
                    )->first();

                    if (!empty($oldFile)) {
                        Storage::delete($oldFile->link);
                    }

                    $uploads->where(
                        'id',$request->$inputId
                    )->update([
                        'type' => $request->upload,
                        'name' => $hashName,
                        'link' => $path
                    ]);

                    $idUpload = $request->$inputId;
                }

                return response()->json([
                    'status' => "success",
                    'message' => "Upload realizado com sucesso.",
                    'link' => $path,
                    'id' => $idUpload
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

