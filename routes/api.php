<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AtivoController;
use App\Http\Controllers\FormulaController;
use App\Http\Controllers\ClienteController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('clientes', ClienteController::class);
Route::apiResource('formulas', FormulaController::class);
Route::apiResource('ativos', AtivoController::class);

Route::get('/docs', function () {
    Artisan::call('l5-swagger:generate');
    return redirect('/api/documentation');
});

