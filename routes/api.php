<?php

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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::get('/ads', [\App\Http\Controllers\Api\AdController::class, 'index'])->middleware('auth:sanctum');
//Route::get('/ads', [\App\Http\Controllers\Api\AdController::class, 'index'])->name('ads');

Route::post('/login', [\App\Http\Controllers\Api\UserController::class, 'login'])->name('login');
Route::post('/register', [\App\Http\Controllers\Api\UserController::class, 'register'])->name('register');
Route::post('/destroy', [\App\Http\Controllers\Api\UserController::class, 'destroy'])->name('destroy');
Route::post('/update', [\App\Http\Controllers\Api\UserController::class, 'update'])->name('update');
Route::post('/logout', [\App\Http\Controllers\Api\UserController::class, 'logout'])->name('logout');
Route::get('/carousel', [\App\Http\Controllers\Api\AdController::class, 'carouselClient'])->name('carousel');
//Route::get('/carousel'[\App\Http\Controllers\Api\AdController::class,'carouselClient'])->name('carousel');
