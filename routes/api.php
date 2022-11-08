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

Route::get('/email/baixar', [EmailController::class, 'storeEmails']);
Route::get('/email/listar', [EmailController::class, 'index']);
Route::get('/email/search', [EmailController::class, 'getBy']);
