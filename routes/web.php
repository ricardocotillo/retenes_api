<?php

use App\Models\Cabpe;
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
    $estado = 'terminado';
    $email_type = 'quote';
    $mnserie = '002';
    $mnroped = '020963';
    $cabpes = Cabpe::with(['detpe', 'detpe.articulo', 'detpe.famdfas', 'ccmtrs', 'ccmcli', 'ccmcpa', 'values', 'instalments'])->where('MNSERIE', $mnserie)->where('MNROPED', $mnroped)->get();
    $data = array('nombre' => $cabpes[0]->ccmcli->MNOMBRE);


    $mcodven = $cabpes[0]->MCODVEN;
    $ccmcli = $cabpes[0]->ccmcli;

    $recep = config('app.flavor') == 'filtros' ? 'pedidos01_iwb@filtroswillybusch.com.pe' : 'pedidos01_wb@willybusch.com.pe';
    $ctx = $this->get_pedido_info($cabpes);
    $ctx['email_type'] = $email_type;
    return view('attach.new_pedido', $ctx);
});
