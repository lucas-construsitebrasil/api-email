<?php

use App\Http\Controllers\api\EmailController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Route::get('/email/listar', [EmailController::class, 'storeEmails']); 
//Route::get('/email/recebidos/filtrar/{filtro}', [EmailController::class, 'filterReceived']);
//Route::get('/email/enviados/filtrar/{filtro}', [EmailController::class, 'filterSended']);
//Route::post('/email/enviar', [EmailController::class, 'sendEmail']);

Route::group(['prefix' => 'email'], function () {
    Route::prefix('received/')->name('received')->group(function () {
        Route::get('', [EmailController::class, 'storeEmails'])->name('storeEmails');
        Route::get('{filtro}', [EmailController::class, 'filterReceived'])->name('filterReceived');
    });
    Route::prefix('send/')->name('send')->group(function () {
        Route::get('', [EmailController::class, 'getAllSendedEmails'])->name('getAllSendedEmails');
        Route::get('{filtro}', [EmailController::class, 'filterSended'])->name('filterSended');
        Route::post('', [EmailController::class, 'sendEmail'])->name('sendEmail');
    });
});

Route::get('/', function () {
    return "A Documentação da API se encontra no READ.ME!";
});
