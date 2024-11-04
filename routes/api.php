<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjetController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\StatutController;
use App\Http\Controllers\TachesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', [LoginController::class , 'login']);   

Route::middleware('auth:api')->group(function(){
    Route::get('utilisateur', [UserController::class, 'index']);
    Route::get('utilisateur/{id}', [UserController::class, 'show']);
    Route::put('utilisateur/{id}', [UserController::class, 'update']);
    Route::delete('utilisateur/{id}', [UserController::class, 'destroy']);

    Route::get('taches/{id}', [TachesController::class, 'show']);
    Route::delete('taches/{id}/validation', [TachesController::class, 'validationdelete'])->middleware('admin');
});

Route::get('taches', [TachesController::class, 'index']);


Route::get('projet', [ProjetController::class, 'index']);
Route::post('projet',[ProjetController::class, 'store']);
Route::get('projet/{id}', [ProjetController::class, 'show']);
Route::delete('projet/{id}', [ProjetController::class, 'destroy']);

Route::post('utilisateur', [Usercontroller::class, 'store']);

Route::post('utilisateur/{idutilisateur}/{idtache}', [Usercontroller::class, 'associeruser']);
Route::post('utilisateur/{idutilisateur}/{idtache}/detach', [Usercontroller::class, 'detacheruser']);


Route::put('connexion/remember', [LoginController::class , 'updateRememberToken']);

Route::get('statut', [StatutController::class, 'index']);
Route::post('statut', [StatutController::class, 'store']);
Route::get('statut/{id}', [StatutController::class, 'show']);
Route::put('statut/{id}', [StatutController::class, 'update']);
Route::delete('statut/{id}', [StatutController::class, 'destroy']);


Route::post('taches', [TachesController::class, 'store']);
Route::put('taches/{id}', [TachesController::class, 'update']);
Route::delete('taches/{id}', [TachesController::class, 'destroy']);