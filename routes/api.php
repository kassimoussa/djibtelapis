<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function(){
    Route::get('fix', [ApisController::class, 'all_fix']);
    Route::get('fix/numero/{nd?}', [ApisController::class, 'nd_fix']);
    Route::get('fix/nom/{nom?}', [ApisController::class, 'nom_fix']);
    Route::get('mobile', [ApisController::class, 'all_mobile']);
    Route::get('mobile/numero/{nd?}', [ApisController::class, 'nd_mobile']);
    Route::get('mobile/nom/{nom?}', [ApisController::class, 'nom_mobile']);

});