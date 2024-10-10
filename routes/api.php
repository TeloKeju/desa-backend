<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\NewsController;

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
Route::post('/news/add', [NewsController::class, "add"]);
Route::patch('/news/update', [NewsController::class, "update"]);
Route::delete('/news/delete', [NewsController::class, "delete"]);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
