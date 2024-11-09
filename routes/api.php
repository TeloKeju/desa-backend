<?php

use App\Http\Controllers\Api\agamaController;
use App\Http\Controllers\Api\apbController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\GaleryController;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\PekerjaanController;
use App\Http\Controllers\Api\PendidikanController;
use App\Http\Controllers\Api\pendudukController;
use App\Http\Controllers\Api\perkawinanController;
use App\Http\Controllers\Api\WisataController;
use App\Http\Controllers\Api\SOTKController;
use App\Http\Controllers\Api\UmkmController;
use App\Http\Controllers\Api\UmurController;
use App\Http\Controllers\Api\WajibPilihController;


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

Route::get('/penduduk', [pendudukController::class, "get"]);
Route::post('/penduduk/update/{id}', [pendudukController::class, "update"]);

Route::get('/agama', [agamaController::class, "get"]);
Route::post('/agama/update/{id}', [agamaController::class, "update"]);

Route::get('/wajibpilih', [WajibPilihController::class, "get"]);
Route::post('/wajibpilih', [WajibPilihController::class, "add"]);
Route::post('/wajibpilih/update/{id}', [WajibPilihController::class, "update"]);
Route::delete('/wajibpilih', [WajibPilihController::class, "delete"]);

Route::get('/apb', [apbController::class, "get"]);
Route::post('/apb', [apbController::class, "add"]);
Route::post('/apb/update/{id}', [apbController::class, "update"]);
Route::delete('/apb', [apbController::class, "delete"]);

Route::get('/perkawinan', [perkawinanController::class, 'get']);
Route::post('/perkawinan/update/{id}', [perkawinanController::class, "update"]);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
