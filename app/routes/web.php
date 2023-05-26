<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\DayController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminShiftController;
use App\Http\Controllers\TestController;
use App\Models\User;
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

Route::get('test', [TestController::class, 'test'])->name('test');
Route::get('test2', [TestController::class, 'test2'])->name('test2');

Route::middleware(['guest'])->group(function () {
    //ログインフォーム表示
    Route::get('/', [AuthController::class, 'showLogin'])->name('login.show');
    // ログイン処理
    Route::post('/', [AuthController::class, 'login'])->name('login');
    //「/admin」のついたURLにアクセスするとログイン画面に戻される
    Route::get('/admin/{uri}', [AuthController::class, 'showLogin'])->where('uri', '.*');
});

Route::middleware(['auth'])->group(function () {
    //ホーム画面
    Route::get('home', [CalendarController::class, 'getHome'])->name('home');
    // Route::get('home2', [CalendarController::class, 'index'])->name('home2');
    //ログアウト
    Route::post('logout', [Authcontroller::class, 'logout'])->name('logout');
    
    Route::get('/day/{date}', [DayController::class, 'showDay'])->name('day');
    Route::get('/request', [CalendarController::class, 'showShiftRequest'])->name('request');
    Route::post('/request', [CalendarController::class, 'dateReserve'])->name('catchRequest');
    Route::get('/user/edit/{id}', [UserController::class, 'showEdit'])->name('edit');
    Route::post('/user/update', [UserController::class, 'exeUpdate'])->name('update');
});

//Admin権限を持っているユーザーのみアクセスさせる
Route::middleware(['auth', 'AdminMiddleware'])->group(function(){
    Route::get('/users', [UserController::class, 'showList'])->name('users');
    Route::post('/user/delete/{id}', [UserController::class, 'exeDelete'])->name('delete');
    Route::get('/users/create', [UserController::class, 'showCreate'])->name('create');
    Route::post('/users/store', [UserController::class, 'exeStore'])->name('store');
    Route::get('/shift/{date}', [AdminShiftController::class, 'showShiftDay'])->name('shiftDay');
    Route::post('/shift/update', [AdminShiftController::class, 'shiftUpdate'])->name('shiftUpdate');
});