<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdmValidateController;
use App\Http\Controllers\AdmVotersController;
use App\Http\Controllers\AdmCandidatesController;
use App\Http\Controllers\AdmGlobalController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['api'])->group(function() {
    // Busca de dados por CEP
    Route::get('cep/do/',[AdmValidateController::class,'AdmCepDo'])->name('adm.cep.do');
    // Validação de RG
    Route::get('validate/rg/do/',[AdmValidateController::class,'AdmRgDo'])->name('adm.valrg.do');
    // Validação de CPF
    Route::get('validate/cpf/do/',[AdmValidateController::class,'AdmCpfDo'])->name('adm.valcpf.do');
    // Validação de CNPJ
    Route::get('validate/cnpj/do/',[AdmValidateController::class,'AdmCnpjDo'])->name('adm.valcnpj.do');
    // Validação de E-mail
    Route::get('validate/email/do/',[AdmValidateController::class,'AdmEmailDo'])->name('adm.valemail.do');
    // Validação da força da senha (password)
    Route::get('validate/password/do/',[AdmValidateController::class,'AdmPasswordDo'])->name('adm.valpassword.do');
    // Busca dos dados para a listagem das categorias com base na localidade
    Route::put('categories/list/do/',[AdmGlobalController::class,'AdmCategoriesListDo'])->name('adm.categories.list.do');
    // Busca dos dados para a listagem das cédulas com base na nos dados passados
    Route::put('cards/list/do/',[AdmGlobalController::class,'AdmCardsListDo'])->name('adm.cards.list.do');
});


