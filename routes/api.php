<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\ArticuloController;
use App\Http\Controllers\API\CcmcliController;
use App\Http\Controllers\API\CcmcpaController;
use App\Http\Controllers\API\ArticuloFamdfaController;
use App\Http\Controllers\API\CcmvenController;
use App\Http\Controllers\API\CabpeController;
use App\Http\Controllers\API\DetpeController;
use App\Http\Controllers\API\CcmtrsController;
use App\Http\Controllers\API\MainViewController;
use App\Http\Controllers\API\UserController;

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

Route::group(['middleware' => ['cors']], function () {
    Route::post('login', [UserController::class, 'login']);
});

Route::group(['middleware' => ['auth:api', 'cors']], function () {
    Route::get('articulos', [ArticuloController::class, 'index']);
    Route::get('articulos/{search}', [ArticuloController::class, 'show']);
    Route::get('clientes', [CcmcliController::class, 'index']);
    Route::get('formas-pago', [CcmcpaController::class, 'index']);
    Route::post('dfa', [ArticuloFamdfaController::class, 'index']);
    Route::get('mcodven/{nombre}', [CcmvenController::class, 'show']);
    Route::post('cabped', [CabpeController::class, 'store']);
    Route::post('historial', [CabpeController::class, 'show']);
    Route::get('detped/{mnserie}/{mnroped}', [DetpeController::class, 'show']);
    Route::get('ccmtrs', [CcmtrsController::class, 'index']);
    Route::get('ccmcpa/{tipo}', [CcmcpaController::class, 'show']);
    Route::post('cambiar', [CcmcpaController::class, 'update']);
    Route::get('mainView/{nombre}', [MainViewController::class,'index']);
    Route::post('register', [UserController::class, 'register']);
    Route::get('descuento_general', [ArticuloFamdfaController::class, 'descuento_general']);
    Route::patch('detpe/{detpe_id}/', [DetpeController::class, 'update']);
    Route::patch('cabpe_update_mcodcpa/{mnserie}/{mnroped}/', [CabpeController::class, 'update_mcodcpa']);
    Route::post('detpe/{mnserie}/{mnroped}/', [DetpeController::class, 'store']);
    Route::delete('detpe/{detpe_id}/', [DetpeController::class, 'destroy']);
});
