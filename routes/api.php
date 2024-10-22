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
use App\Http\Controllers\API\InputController;
use App\Http\Controllers\API\OptionController;
use App\Http\Controllers\API\ValueController;
use App\Http\Controllers\API\InstalmentController;
use App\Models\Setting;
use App\Http\Middleware\Cors;

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
Route::post('login/', [UserController::class, 'login']);
Route::get('data-version/', function() {
    $settings = Setting::first();
    return $settings->data_updated_at;
});
// Route::post('cabpe/send_email/{mnserie}/{mnroped}/', [CabpeController::class, 'send_email']);


Route::middleware(['auth:api',])->group(function () {
    Route::get('articulos/', [ArticuloController::class, 'index']);
    Route::get('articulos/{mcodart}/', [ArticuloController::class, 'articulo']);
    Route::get('articulos/{search}', [ArticuloController::class, 'show']);
    Route::get('clientes/', [CcmcliController::class, 'index']);
    Route::post('ccmcli/', [CcmcliController::class, 'store']);
    Route::get('formas-pago', [CcmcpaController::class, 'index']);
    Route::post('dfa', [ArticuloFamdfaController::class, 'index']);
    Route::get('mcodven/{nombre}', [CcmvenController::class, 'show']);
    Route::post('ccmven/', [CcmvenController::class, 'store']);
    Route::post('cabped', [CabpeController::class, 'store']);
    Route::get('historial/', [CabpeController::class, 'show']);
    Route::get('ccmtrs', [CcmtrsController::class, 'index']);
    Route::get('ccmcpa/{tipo}', [CcmcpaController::class, 'show']);
    Route::post('cambiar', [CcmcpaController::class, 'update']);
    Route::get('mainView/{nombre}', [MainViewController::class,'index']);
    Route::post('register', [UserController::class, 'register']);
    Route::get('descuento_general/{mcodven}/', [ArticuloFamdfaController::class, 'descuento_general']);
    Route::patch('detpe/{detpe_id}/', [DetpeController::class, 'update']);
    Route::patch('detpe/{detpe_id}/update_item_state/', [DetpeController::class, 'update_item_state']);
    Route::patch('detpe/{detpe_id}/update_fecha_despacho/', [DetpeController::class, 'update_fecha_despacho']);
    Route::patch('detpe/{detpe_id}/update_partial/', [DetpeController::class, 'update_partial']);
    Route::patch('detpe/{detpe_id}/update_status_changed', [DetpeController::class, 'update_status_changed']);
    Route::post('detpe/{mnserie}/{mnroped}/', [DetpeController::class, 'store']);
    Route::delete('detpe/{detpe_id}/', [DetpeController::class, 'destroy']);
    Route::get('detped/{mnserie}/{mnroped}', [DetpeController::class, 'show']);
    Route::patch('cabpe/{id}/update_famdfa/', [CabpeController::class, 'update_famdfa']);
    Route::delete('cabpe/{id}/remove_famdfa/', [CabpeController::class, 'remove_famdfa']);
    Route::post('cabpe/{mnserie}/{mnroped}/add_famdfa/', [CabpeController::class, 'add_famdfa']);
    Route::patch('cabpe_update_mcodcpa/{mnserie}/{mnroped}/', [CabpeController::class, 'update_mcodcpa']);
    Route::post('cabpe/send_email/{mnserie}/{mnroped}/', [CabpeController::class, 'send_email']);
    Route::patch('cabpe/update_descuento_general/{id}/', [CabpeController::class, 'update_descuento_general']);
    Route::patch('cabpe/update_ccmtrs/{mnserie}/{mnroped}/', [CabpeController::class, 'update_ccmtrs']);
    Route::patch('cabpe/update_mobserv/{mnserie}/{mnroped}/', [CabpeController::class, 'update_mobserv']);
    Route::patch('cabpe/update_item_state/{mnserie}/{mnroped}/', [CabpeController::class, 'update_item_state']);
    Route::patch('cabpe/update_fecha_despacho/{mnserie}/{mnroped}/', [CabpeController::class, 'update_fecha_despacho']);
    Route::get('cabpe/show_by_range/{mcodcli}/{range}/', [CabpeController::class, 'show_by_range']);
    Route::patch('cabpe/{mnserie}/{mnroped}/modifications/', [CabpeController::class, 'modifications']);
    Route::resource('inputs', InputController::class);
    Route::resource('options', OptionController::class);
    Route::post('values/bulk_store/', [ValueController::class, 'bulk_store']);
    Route::delete('values/bulk_delete/{mnserie}/{mnroped}/', [ValueController::class, 'bulk_delete']);
    Route::post('instalments/bulk_store/', [InstalmentController::class, 'bulk_store']);
    Route::delete('instalments/bulk_delete/{mnserie}/{mnroped}/', [InstalmentController::class, 'bulk_delete']);
});