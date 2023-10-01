<?php

use App\Http\Controllers\API\PostsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\UserController;
use App\Http\Controllers\ColiController;



 //***********Interface Admin**************//
 Route::middleware('auth:sanctum')->group(function () {
//Admin

Route::get('admins/get_all_admins', [UserController::class, 'get_all_admins']);
Route::post('admin/create', [UserController::class, 'createAdmin']);
Route::put('admin/update/{id}', [UserController::class, 'updateAdmin']);
Route::post('admin/disable/{id}', [UserController::class, 'disableAdmin']);

//Expediteur

Route::get('expediteurs/get_all_expediteurs', [UserController::class, 'get_all_expediteurs']);
Route::post('expediteur/create', [UserController::class, 'createExpediteur']);
Route::put('expediteur/update/{id}', [UserController::class, 'updateExpediteur']);
Route::post('expediteur/disable/{id}', [UserController::class, 'disableExpediteur']);


//Livreur

Route::get('livreurs/get_all_livreurs', [UserController::class, 'get_all_livreurs']);
Route::post('livreur/create', [UserController::class, 'createLivreur']);
Route::put('livreur/update/{id}', [UserController::class, 'updateLivreur']);
Route::post('livreur/disable/{id}', [UserController::class, 'disableLivreur']);

//Colis
Route::get('colis/get_all_colis', [ColiController::class, 'get_all_colis']);
Route::post('colis/create', [ColiController::class, 'createColis']);
Route::put('colis/update/{id}', [ColiController::class, 'updateColis']);


});

//Auth
Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);
Route::post('logout', [UserController::class, 'logout'])->middleware('auth:sanctum');





// Route::group(['prefix' => 'posts','middleware' => 'auth:sanctum'], function() {
//     Route::get('/', [PostsController::class,'index']);
//     Route::post('add', [PostsController::class,'add']);
//     Route::post('update/{id}', [PostsController::class,'update']);
//     Route::get('edit/{id}', [PostsController::class,'edit']);
//     Route::delete('delete/{id}', [PostsController::class,'delete']);
// });
