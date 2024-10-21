<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\GaleryController;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\PekerjaanController;
use App\Http\Controllers\Api\PendidikanController;
use App\Http\Controllers\Api\WisataController;
use App\Http\Controllers\Api\SOTKController;
use App\Http\Controllers\Api\UmkmController;
use App\Http\Controllers\Api\UmurController;




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

Route::get('/galery', [GaleryController::class, "get"]);
Route::post('/galery', [GaleryController::class, "add"]);
Route::post('/galery/update/{id}', [GaleryController::class, "update"]);
Route::delete('/galery', [GaleryController::class, "delete"]);

Route::get('/wisata', [WisataController::class, "get"]);
Route::post('/wisata', [WisataController::class, "add"]);
Route::post('/wisata/update/{id}', [WisataController::class, "update"]);
Route::delete('/wisata', [WisataController::class, "delete"]);

Route::get('/umkm', [UmkmController::class, "get"]);
Route::post('/umkm', [UmkmController::class, "add"]);
Route::post('/umkm/update/{id}', [UmkmController::class, "update"]);
Route::delete('/umkm', [UmkmController::class, "delete"]);

Route::get('/pekerjaan', [PekerjaanController::class, "get"]);
Route::post('/pekerjaan', [PekerjaanController::class, "add"]);
Route::post('/pekerjaan/update/{id}', [PekerjaanController::class, "update"]);
Route::delete('/pekerjaan', [PekerjaanController::class, "delete"]);

Route::get('/penduduk/umur', [UmurController::class, "get"]);
Route::post('/penduduk/umur/update/{id}', [UmurController::class, "update"]);

Route::get('/penduduk/pendidikan', [PendidikanController::class, "get"]);
Route::post('/penduduk/pendidikan/update/{id}', [PendidikanController::class, "update"]);



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
