<?php

use App\Http\Controllers\AdController;
use App\Http\Controllers\AdItemController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StatisticsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => ['auth']], function() {

    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class,'index'])->name('dashboard');

});
//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
// new routes

Route::group(['middleware' => ['auth']], function() {

    Route::get('/carousel',[AdController::class, 'carousel'])->name('carousel');
    Route::get('/ads/adItem', [AdController::class,'adItem'])->name('adItem');
    Route::post('/ads/adItem/store',[AdItemController::class,'store'])->name('adItem.store');
    Route::post('/store',[AdController::class,'store'])->name('ad.store');
    Route::get('/ads', [AdController::class,'index'])->name('ads');
    Route::get('/ads/all', [AdController::class,'allAds'])->name('ads.all');
    Route::get('/ads/create', [AdController::class,'addAds'])->name('ads.add');
    Route::get('/ads/items', [AdController::class,'items'])->name('ads.items');
    Route::get('/ads/details', [AdController::class,'getAd'])->name('ads.get');


});
Route::get('/statistics', [StatisticsController::class, 'index'])->name('statistics');
