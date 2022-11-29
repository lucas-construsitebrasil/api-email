<?php

use App\Http\Controllers\Email\EmailController;
use App\Http\Controllers\Email\ReceivedEmailController;
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

Route::group(['prefix' => 'email'], function () {
    Route::prefix('received/')->name('received')->group(function () {
        Route::get('', [ReceivedEmailController::class, 'index'])->name('index');
        Route::get('/filtro', [ReceivedEmailController::class, 'show'])->name('show');
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
