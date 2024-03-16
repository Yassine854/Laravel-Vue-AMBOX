<?php

use App\Http\Controllers\API\PostsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\UserController;
use App\Http\Controllers\ColiController;
use App\Http\Controllers\HistoriqueController;
use App\Http\Controllers\AffectationController;
use App\Http\Controllers\Affectation2Controller;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\SoldeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\LivraisonController;


 //***********Interface Admin**************//
 Route::middleware('auth:sanctum')->group(function () {
//Admin

Route::get('admins/get_all_admins', [UserController::class, 'get_all_admins']);
Route::post('admin/create', [UserController::class, 'createAdmin']);
Route::put('admin/update/{id}', [UserController::class, 'updateAdmin']);
Route::post('admin/disable/{id}', [UserController::class, 'disableAdmin']);
Route::post('admin/enable/{id}', [UserController::class, 'enableAdmin']);

//Expediteur

Route::get('expediteurs/get_all_expediteurs', [UserController::class, 'get_all_expediteurs']);
Route::post('expediteur/create', [UserController::class, 'createExpediteur']);
Route::put('expediteur/update/{id}', [UserController::class, 'updateExpediteur']);
Route::post('expediteur/disable/{id}', [UserController::class, 'disableExpediteur']);
Route::post('expediteur/enable/{id}', [UserController::class, 'enableExpediteur']);


//Livreur

Route::get('livreurs/get_all_livreurs', [UserController::class, 'get_all_livreurs']);
Route::get('livreurs/get_all_expediteurs_colis', [ColiController::class, 'get_all_expediteurs_colis']);

Route::post('livreur/create', [UserController::class, 'createLivreur']);
Route::put('livreur/update/{id}', [UserController::class, 'updateLivreur']);
Route::post('livreur/disable/{id}', [UserController::class, 'disableLivreur']);
Route::post('livreur/enable/{id}', [UserController::class, 'enableLivreur']);

//Colis
Route::get('colis/get_all_colis', [ColiController::class, 'get_all_colis']);
Route::get('colis/get_expediteurs_colis/{id}', [ColiController::class, 'get_expediteurs_colis']);
Route::get('colis/get_all_manifestes_colis', [ColiController::class, 'get_all_manifestes_colis']);
Route::get('colis/get_all_paiements_colis', [ColiController::class, 'get_all_paiements_colis']);
Route::get('colis/get_all_retours_colis', [ColiController::class, 'get_all_retours_colis']);


Route::post('colis/create', [ColiController::class, 'createColis']);
Route::put('colis/update/{id}', [ColiController::class, 'updateColis']);
Route::put('colis/updateState/{id}', [ColiController::class, 'updateState']);
Route::put('colis/updateSelectedStates/', [ColiController::class, 'updateSelectedStates']);
Route::get('colis/imprimer/{id}', [ColiController::class, 'imprimercolis']);
Route::put('colis/LivrerRetour/', [ColiController::class, 'LivrerRetour']);


//Affectation
Route::get('colis/get_livreurs_colis/{id}', [AffectationController::class, 'get_livreurs_colis']);
Route::get('colis/get_livreurs_colis_par_agence/{id}/{agence}', [AffectationController::class, 'get_livreurs_colis_par_agence']);

Route::post('affectations/PickupEnleverLivreur', [AffectationController::class, 'PickupEnleverLivreur']);



//Affectation2 (Livraison 2)
Route::post('affectations2/PickupDepotSortant', [Affectation2Controller::class, 'PickupDepotSortant']);
Route::get('colis/get_all_Encours_colis/{id}', [Affectation2Controller::class, 'get_all_Encours_colis']);
Route::get('get_all_livreurs_livraisons', [Affectation2Controller::class, 'get_all_livreurs_livraisons']);


//Historiques
Route::get('historiques/{id}', [HistoriqueController::class, 'showHistoriques']);

//Paiement Expediteur

Route::post('paiement/create', [PaiementController::class, 'createPaiement']);
Route::get('paiement/get_all_expediteur_paiements/{id}', [PaiementController::class, 'get_all_expediteur_paiements']);
Route::get('/expediteurs/get_expediteur_name/{id}', [PaiementController::class, 'get_expediteur_name']);


//Solde
Route::post('admin/calculerSolde/{id}', [SoldeController::class, 'calcule_solde']);
Route::get('get_solde/{id}', [SoldeController::class, 'get_solde']);


//Livraison
Route::get('livreurs/get_livreur_name/{id}', [LivraisonController::class, 'get_livreur_name']);
Route::get('livraisons/get_all_livraisons/{id}', [LivraisonController::class, 'get_all_livraisons']);


});

//Auth
Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);
Route::post('logout', [UserController::class, 'logout'])->middleware('auth:sanctum');

Route::post('/password/reset', [PasswordResetController::class, 'resetPassword']);

Route::post('/password/reset/{token}/{email}', [PasswordResetController::class, 'reset'])
    ->name('api.password.reset');


//Profile

Route::post('/user/verifyOldPassword/{id}', [UserController::class, 'verifyOldPassword']);
Route::put('/user/updatePassword/{id}', [UserController::class, 'updatePassword']);

//Dashboard
    //Admin
    Route::get('dashboard/fetchAdminsCount', [DashboardController::class, 'fetchAdminsCount']);
    Route::get('dashboard/fetchExpediteursCount', [DashboardController::class, 'fetchExpediteursCount']);
    Route::get('dashboard/fetchLivreursCount', [DashboardController::class, 'fetchLivreursCount']);
    Route::get('dashboard/fetchTotalColisCount', [DashboardController::class, 'fetchTotalColisCount']);
    Route::get('dashboard/fetchColisAttenteCount', [DashboardController::class, 'fetchColisAttenteCount']);
    Route::get('dashboard/fetchColisEnDepotCount', [DashboardController::class, 'fetchColisEnDepotCount']);
    Route::get('dashboard/fetchRetourDepotCount', [DashboardController::class, 'fetchRetourDepotCount']);
    Route::get('dashboard/fetchEncoursCount', [DashboardController::class, 'fetchEncoursCount']);
    Route::get('dashboard/fetchColisLivreCount', [DashboardController::class, 'fetchColisLivreCount']);
    Route::get('dashboard/fetchRetourDefinitifCount', [DashboardController::class, 'fetchRetourDefinitifCount']);
    Route::get('dashboard/cityBarChart', [DashboardController::class, 'cityBarChart']);
    Route::get('dashboard/topLivreurBarChart', [DashboardController::class, 'topLivreurBarChart']);


    //Expediteur

    Route::get('dashboard/expediteur_fetchTotalColisCount/{id}', [DashboardController::class, 'expediteur_fetchTotalColisCount']);
    Route::get('dashboard/expediteur_fetchColisAttenteCount/{id}', [DashboardController::class, 'expediteur_fetchColisAttenteCount']);
    Route::get('dashboard/expediteur_fetchColisEnDepotCount/{id}', [DashboardController::class, 'expediteur_fetchColisEnDepotCount']);
    Route::get('dashboard/expediteur_fetchRetourDepotCount/{id}', [DashboardController::class, 'expediteur_fetchRetourDepotCount']);
    Route::get('dashboard/expediteur_fetchEncoursCount/{id}', [DashboardController::class, 'expediteur_fetchEncoursCount']);
    Route::get('dashboard/expediteur_fetchColisLivreCount/{id}', [DashboardController::class, 'expediteur_fetchColisLivreCount']);
    Route::get('dashboard/expediteur_fetchRetourDefinitifCount/{id}', [DashboardController::class, 'expediteur_fetchRetourDefinitifCount']);
    Route::get('dashboard/expediteur_cityBarChart/{id}', [DashboardController::class, 'expediteur_cityBarChart']);

//Livreur

Route::get('dashboard/livreur_fetchColisAttenteCount/{id}', [DashboardController::class, 'livreur_fetchColisAttenteCount']);
Route::get('dashboard/livreur_fetchColisEnLivreurCount/{id}', [DashboardController::class, 'livreur_fetchColisEnLivreurCount']);
Route::get('dashboard/livreur_fetchColisEnDepotCount/{id}', [DashboardController::class, 'livreur_fetchColisEnDepotCount']);
Route::get('dashboard/livreur_fetchRetourDepotCount/{id}', [DashboardController::class, 'livreur_fetchRetourDepotCount']);
Route::get('dashboard/livreur_fetchEncoursCount/{id}', [DashboardController::class, 'livreur_fetchEncoursCount']);
Route::get('dashboard/livreur_fetchColisLivreCount/{id}', [DashboardController::class, 'livreur_fetchColisLivreCount']);
Route::get('dashboard/livreur_fetchRetourDefinitifCount/{id}', [DashboardController::class, 'livreur_fetchRetourDefinitifCount']);
Route::get('dashboard/livreur_cityBarChart/{id}', [DashboardController::class, 'livreur_cityBarChart']);



// Route::group(['prefix' => 'posts','middleware' => 'auth:sanctum'], function() {
//     Route::get('/', [PostsController::class,'index']);
//     Route::post('add', [PostsController::class,'add']);
//     Route::post('update/{id}', [PostsController::class,'update']);
//     Route::get('edit/{id}', [PostsController::class,'edit']);
//     Route::delete('delete/{id}', [PostsController::class,'delete']);
// });
