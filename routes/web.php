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
use App\Http\Controllers\AdmLocationController;
use App\Http\Controllers\AdmVotersController;
use App\Http\Controllers\AdmCardsController;
use App\Http\Controllers\AdmCandidatesController;
use App\Http\Controllers\AdmCoutingController;
use App\Http\Controllers\BoothLoginController;
use App\Http\Controllers\BoothIndicationController;
use App\Http\Controllers\BoothElectionController;
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

   // -- | NIVEL ADM | --
   Route::get('/adm',[AdmLoginController::class, 'AdmLoginAdm'])->name('adm.login.adm');
   Route::get('/adm/cpanel', [AdmLoginController::class, 'AdmCPanel'])->name('adm.cpanel');
   Route::post('adm/login/do',[AdmLoginController::class,'AdmLoginDo'])->name('adm.login.do');

   // Logout
   Route::get('/adm/logout',[AdmLoginController::class,'AdmLogout'])->name('adm.logout');

   // Esqueci Minha Senha
   Route::get('/adm/forgot',[AdmLoginController::class, 'AdmForgot'])->name('adm.forgot');
   Route::post('adm/forgot/do',[AdmLoginController::class,'AdmForgotDo'])->name('adm.forgot.do');
   Route::get('adm/reset/{token}',[AdmLoginController::class,'AdmReset'])->name('adm.reset');
   Route::post('adm/reset/do',[AdmLoginController::class,'AdmResetDo'])->name('adm.reset.do');

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

   // Localidades
   Route::get('/adm/location',[AdmLocationController::class,'AdmLocation'])->name('adm.location');
   Route::get('/adm/locations',[AdmLocationController::class,'AdmLocations'])->name('adm.locations');
   Route::get('/adm/location/{location}',[AdmLocationController::class, 'AdmEditLocation'])->name('adm.edit.location');
   Route::put('/adm/location/do',[AdmLocationController::class,'AdmLocationDo'])->name('adm.location.do');
   Route::put('adm/location/delete/do',[AdmLocationController::class, 'AdmDelLocationDo'])->name('adm.del.location.do');

   // Eleitores
   Route::get('/adm/voter',[AdmVotersController::class,'AdmVoter'])->name('adm.voter');
   Route::get('/adm/voters',[AdmVotersController::class, 'AdmVoters'])->name('adm.voters');
   Route::put('/adm/voter/do',[AdmVotersController::class,'AdmVoterDo'])->name('adm.voter.do');
   Route::get('/adm/voter/{voter}/{local}',[AdmVotersController::class, 'AdmEditVoter'])->name('adm.edit.voter');
   Route::put('adm/voter/delete/do',[AdmVotersController::class, 'AdmDelVoterDo'])->name('adm.del.voter.do');
   Route::get('adm/voters/import',[AdmVotersController::class, 'AdmImportVoters'])->name('adm.import.voters');

   // Cédulas
   Route::get('/adm/card',[AdmCardsController::class,'AdmCard'])->name('adm.card');
   Route::get('/adm/cards',[AdmCardsController::class, 'AdmCards'])->name('adm.cards');
   Route::get('/adm/card/{card}/{local}',[AdmCardsController::class, 'AdmEditCard'])->name('adm.edit.card');
   Route::put('/adm/card/do',[AdmCardsController::class,'AdmCardDo'])->name('adm.card.do');
   Route::put('adm/card/delete/do',[AdmCardsController::class, 'AdmDelCardDo'])->name('adm.del.card.do');

   // Candidados
   Route::get('/adm/candidate',[AdmCandidatesController::class,'AdmCandidate'])->name('adm.candidate');
   Route::get('/adm/candidates',[AdmCandidatesController::class, 'AdmCandidates'])->name('adm.candidates');
   Route::get('/adm/candidate/{candidate}',[AdmCandidatesController::class, 'AdmEditCandidate'])->name('adm.edit.candidate');
   Route::put('/adm/candidate/do',[AdmCandidatesController::class,'AdmCandidateDo'])->name('adm.candidate.do');
   Route::put('adm/candidate/delete/do',[AdmCandidatesController::class, 'AdmDelCandidateDo'])->name('adm.del.candidate.do');

   // Apuração
   Route::get('/adm/coutingIndicates',[AdmCoutingController::class,'AdmCoutingIndicates'])->name('adm.couting.indicates');
   Route::get('/adm/coutingListIndicates/{card}/{type}',[AdmCoutingController::class,'AdmCoutingIndicatesList'])->name('adm.couting.indicates.list');
   Route::put('/adm/coutingListIndicates/do',[AdmCoutingController::class,'AdmCoutingIndicatesListDo'])->name('adm.couting.indicates.list.do');
   Route::get('/adm/coutingCandidates',[AdmCoutingController::class,'AdmCoutingCandidates'])->name('adm.couting.candidates');
   Route::get('/adm/coutingVoters',[AdmCoutingController::class,'AdmCoutingVoters'])->name('adm.couting.voters');
   Route::post('adm/voter/info',[AdmCoutingController::class,'AdmVoterInfo'])->name('adm.voter.info');
   Route::get('/adm/printElection',[AdmCoutingController::class,'AdmPrintElection'])->name('adm.print.election');
   Route::get('/adm/printVoters',[AdmCoutingController::class,'AdmPrintVoters'])->name('adm.print.voters');


   // --| NIVEL BOOTH (ELEITOR / CABINE DE VOTAÇÃO) |--
   Route::get('/booth',[BoothLoginController::class, 'BoothLoginBooth'])->name('Booth.login.Booth');
   Route::get('/booth/cpanel',[BoothLoginController::class, 'BoothCPanel'])->name('booth.cpanel');
   Route::post('booth/login/do',[BoothLoginController::class,'BoothLoginDo'])->name('booth.login.do');

   // Logout
   Route::get('/booth/logout',[BoothLoginController::class,'BoothLogout'])->name('booth.logout');

   // Esqueci Minha Senha
   Route::get('/booth/forgot',[BoothLoginController::class, 'BoothForgot'])->name('booth.forgot');
   Route::post('booth/forgot/do',[BoothLoginController::class,'BoothForgotDo'])->name('booth.forgot.do');
   Route::get('booth/reset/{token}',[BoothLoginController::class,'BoothReset'])->name('booth.reset');
   Route::post('booth/reset/do',[BoothLoginController::class,'BoothResetDo'])->name('booth.reset.do');

   // Indicação
   Route::get('/booth/indication/{card}',[BoothIndicationController::class, 'BoothIndication'])->name('booth.indication');
   Route::post('booth/indication/do',[BoothIndicationController::class,'BoothIndicationDo'])->name('booth.indication.do');
   Route::get('booth/confirm',[BoothElectionController::class,'BoothConfirm'])->name('booth.confirm');

   // Eleição
   Route::get('/booth/election/{card}',[BoothElectionController::class, 'BoothElection'])->name('booth.election');
   Route::post('booth/election/do',[BoothElectionController::class,'BoothElectionDo'])->name('booth.election.do');
   Route::post('booth/election/info',[BoothElectionController::class,'BoothElectionInfo'])->name('booth.election.info');

   // Logout
   Route::get('/booth/logout',[BoothLoginController::class,'BoothLogout'])->name('booth.logout');
});
