<?php

use App\Http\Controllers\API\CabpeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/optimize', function () {
    \Illuminate\Support\Facades\Artisan::call('optimize');
    return response()->json(['optimize' => 'done'], 200);
});
Route::options('{any}', function () {
    return response()->json();
})->where('any', '.*');

Route::get('cabpe/download_txt/{mnserie}/{mnroped}/', [CabpeController::class, 'download_txt']);
Route::get('cabpe/download_pdf/{mnserie}/{mnroped}/', [CabpeController::class, 'download_pdf']);
Route::get('new_pedido', function () {
    $ctx = [
        'flavor' => config('app.flavor')
    ];
    return view('new_pedido', $ctx);
});
