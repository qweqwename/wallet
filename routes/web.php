<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ReplenishmentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::middleware(['guest'])->group(function(){
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::get('loginAsAdmin', [LoginController::class, 'loginAsAdmin'])->name('loginAsAdmin');

    Route::get('login', [LoginController::class, 'index'])->name('login');
    Route::post('login/store', [LoginController::class, 'store'])->name('login.store');

    Route::get('register', [RegisterController::class, 'index'])->name('register');
});


Route::middleware(['auth'])->group(function(){
    Route::get('transfer', [PaymentController::class, 'transfer'])->name('payment.transfer');
    Route::post('transfer', [PaymentController::class, 'store'])->name('payment.store');
    Route::get('{payment}', [PaymentController::class, 'show'])->name('payment.show')->whereNumber('payment');
});

Route::middleware(['auth'])->group(function(){
    Route::get('replenishment', [ReplenishmentController::class, 'create'])->name('replenishment.create');
    Route::post('replenishment', [ReplenishmentController::class, 'store'])->name('replenishment.store');
});

Route::middleware(['auth'])->group(function(){
    Route::get('settings', [UserController::class, 'settings'])->name('user.settings');
    Route::put('settings', [UserController::class, 'update'])->name('user.update');
    Route::get('logout', [UserController::class, 'logout'])->name('user.logout');
});

Route::middleware(['auth', 'admin'])->group(function(){
    Route::get('admin', [AdminController::class, 'settings'])->name('admin');
    Route::put('admin', [AdminController::class, 'update'])->name('admin.update');
});
