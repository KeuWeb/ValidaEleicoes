<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdmLoginController;
use App\Http\Controllers\AdmTypeController;
use App\Http\Controllers\AdmFormController;
use App\Http\Controllers\AdmRuleController;
use App\Http\Controllers\AdmElectionController;
use App\Http\Controllers\AdmCompanyController;
use App\Http\Controllers\AdmCommunicationController;
use App\Http\Controllers\AdmMailingController;
use App\Http\Controllers\AdmUploadsController;
use App\Http\Controllers\AdmUsersController;
use App\Http\Controllers\AdmCategoryController;
use Illuminate\Support\Facades\Session;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['web'])->group(function(){
   Route::get('/adm',function(){
      return view('adm/login');
   });

   Route::get('/adm/cpanel', function (Request $request){
      $id = $request->session()->get('id');
      $name = $request->session()->get('name');

      if(!$id || !$name){
         return redirect('/adm');
      }else{
         return view('adm/cpanel');
      }
   });
   Route::post('adm/login/do',[AdmLoginController::class,'AdmLoginDo'])->name('adm.login.do');

   // Configurações
   Route::get('/adm/type',[AdmTypeController::class, 'AdmType'])->name('adm.type');
   Route::get('/adm/form',[AdmFormController::class, 'AdmForm'])->name('adm.form');
   Route::get('/adm/rule',[AdmRuleController::class, 'AdmRule'])->name('adm.rule');
   Route::get('/adm/election',[AdmElectionController::class, 'AdmElection'])->name('adm.election');
   Route::get('/adm/company',[AdmCompanyController::class, 'AdmCompany'])->name('adm.company');
   Route::get('/adm/communication',[AdmCommunicationController::class, 'AdmCommunication'])->name('adm.communication');
   Route::get('/adm/mailing',[AdmMailingController::class, 'AdmMailing'])->name('adm.mailing');
   Route::get('/adm/uploads',[AdmUploadsController::class, 'AdmUploads'])->name('adm.uploads');
   Route::put('adm/type/do',[AdmTypeController::class, 'AdmTypeDo'])->name('adm.type.do');
   Route::put('adm/form/do',[AdmFormController::class, 'AdmFormDo'])->name('adm.form.do');
   Route::put('adm/rule/do',[AdmRuleController::class, 'AdmRuleDo'])->name('adm.rule.do');
   Route::put('adm/election/do',[AdmElectionController::class, 'AdmElectionDo'])->name('adm.election.do');
   Route::put('adm/company/do',[AdmCompanyController::class, 'AdmCompanyDo'])->name('adm.company.do');
   Route::put('adm/communication/do',[AdmCommunicationController::class, 'AdmCommunicationDo'])->name('adm.communication.do');
   Route::put('adm/mailing/do',[AdmMailingController::class, 'AdmMailingDo'])->name('adm.mailing.do');
   Route::post('adm/uploads/do',[AdmUploadsController::class, 'AdmUploadsDo'])->name('adm.uploads.do');
   
   // Usuários
   Route::get('/adm/user',[AdmUsersController::class, 'AdmUser'])->name('adm.user');
   Route::get('/adm/users/',[AdmUsersController::class, 'AdmUsers'])->name('adm.users');
   Route::get('/adm/user/{user}',[AdmUsersController::class, 'AdmEditUser'])->name('adm.edit.user');
   Route::put('adm/user/do',[AdmUsersController::class, 'AdmUserDo'])->name('adm.user.do');
   Route::put('adm/user/delete/do',[AdmUsersController::class, 'AdmDelUserDo'])->name('adm.del.user.do');

   // Categorias
   Route::get('/adm/category',[AdmCategoryController::class,'AdmCategory'])->name('adm.category');
   Route::get('/adm/categories',[AdmCategoryController::class,'AdmCategories'])->name('adm.categories');
   Route::get('/adm/category/{category}',[AdmCategoryController::class, 'AdmEditCategory'])->name('adm.edit.category');
   Route::put('/adm/category/do',[AdmCategoryController::class,'AdmCategoryDo'])->name('adm.category.do');
   Route::put('adm/category/delete/do',[AdmCategoryController::class, 'AdmDelCategoryDo'])->name('adm.del.category.do');

});
