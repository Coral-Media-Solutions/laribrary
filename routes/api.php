<?php

use App\Http\Controllers\Api\TokenAuthApiController;
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

Route::post('/token', [TokenAuthApiController::class, 'tokenAction']);

Route::group(
    ['middleware' => 'auth:sanctum'],
    function() {
        Route::get(
            '/token/revoke', [TokenAuthApiController::class, 'revokeTokenAction']
        );
        Route::get('/user', function (Request $request) {
            return $request->user();
        });
    }
);
