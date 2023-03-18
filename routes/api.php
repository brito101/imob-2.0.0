<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\AuthController;

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

/* * API */
Route::name('api.')->group(function() {

    Route::post('/auth/login', [AuthController::class, 'login'])->name('login');

    Route::group(['middleware' => ['apiJWT']], function() {
        Route::post('/auth/logout', [AuthController::class, 'logout'])->name('logout');
        Route::post('/me', [AuthController::class, 'me'])->name('me');
        Route::apiResource('/company', CompanyController::class);
    });
});
