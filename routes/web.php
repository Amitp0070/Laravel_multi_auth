<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::group(['prefix' => 'account'], function(){
    
    Route::group(['middleware' => 'guest'], function(){
        Route::get('register',[LoginController::class, 'registerPage'])->name('account.register');
        Route::get('login',[LoginController::class, 'loginPage'])->name('account.login');
        Route::post('process-register',[LoginController::class, 'processRegister'])->name('account.processRegister');
        Route::post('athenticate',[LoginController::class, 'athenticate'])->name('account.athenticate');
    });

    Route::group(['middleware' => 'auth'], function(){
        Route::get('logout',[LoginController::class, 'logout'])->name('account.logout');
        Route::get('dashboard',[DashboardController::class, 'index'])->name('account.dashboard');

    });
});
