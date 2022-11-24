<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FileInfosController;
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

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('registration', [AuthController::class, 'registration']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::middleware('auth')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('me', [AuthController::class, 'me']);
    });
});

Route::group(['prefix' => 'files', 'middleware' => 'auth'], function () {
    Route::group(['prefix' => 'create'], function () {
       Route::post('folder', [FileInfosController::class, 'createFolder']);
    });
    Route::get('/', [FileInfosController::class, 'index']);
    Route::patch('{id}/rename', [FileInfosController::class, 'rename']);
});
