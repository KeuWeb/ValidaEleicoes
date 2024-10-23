<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdmCompanyController;
use App\Http\Controllers\AdmUsersController;
use App\Http\Controllers\AdmVotersController;

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
    Route::get('cep/do/',[AdmCompanyController::class,'AdmCepDo'])->name('adm.cep.do');
    // Validação de CNPJ
    Route::get('validate/cnpj/do/',[AdmCompanyController::class,'AdmCnpjDo'])->name('adm.valcnpj.do');
    // Validação da força da senha (password)
    Route::get('validate/password/do/',[AdmUsersController::class,'AdmPasswordDo'])->name('adm.valpassword.do');
    // Busca dos dados para a listagem das categorias com base na localidade
    Route::put('categories/list/do/',[AdmVotersController::class,'AdmCategoriesListDo'])->name('adm.categories.list.do');
});    


