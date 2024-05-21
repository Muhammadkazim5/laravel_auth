<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\LoginController as AdminLoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::group(['prefix' => 'account'], function () {
    Route::group(['middleware' => 'guest'], function () {
        Route::get('login', [LoginController::class, 'login'])->name('acoount.login');
        Route::get('register', [LoginController::class, 'register'])->name('acoount.register');
        Route::post('authenticate', [LoginController::class, 'authenticate'])->name('acoount.authenticate');
        Route::post('registerauth', [LoginController::class, 'registerauth'])->name('acoount.registerauth');

    });
    Route::group(['middleware' => 'auth'], function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('acoount.dashboard');
        Route::get('logout', [LoginController::class, 'logout'])->name('acoount.logout');
    });
});
Route::group(['prefix' => 'admin'], function () {
    Route::group(['middleware' => 'admin.guest'], function () {
        Route::get('login', [AdminLoginController::class, 'login'])->name('admin.login');
        Route::post('authenticate', [AdminLoginController::class, 'authenticates'])->name('admin.authenticates');
    });
    Route::group(['middleware' => 'admin.auth'], function () {
        Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('logout', [AdminLoginController::class, 'logout'])->name('admin.logout');
    });
});
