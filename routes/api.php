<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\SOTKController;

// use App\Http\Controllers\Api\SOTKController;



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
// Auth
Route::post('/login', [AuthController::class, "login"])->name('login');

// News
Route::get('/news', [NewsController::class, "get"]);
Route::post('/news', [NewsController::class, "add"]);
Route::post('/news/update/{id}', [NewsController::class, "update"]);
Route::delete('/news', [NewsController::class, "delete"]);

Route::get('/sotk', [SOTKController::class, "get"]);
Route::post('/sotk', [SOTKController::class, "add"]);
Route::post('/sotk/update/{id}', [SOTKController::class, "update"]);
Route::delete('/sotk', [SOTKController::class, "delete"]);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
