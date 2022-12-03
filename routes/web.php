<?php

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

Route::get('/', function () {
    return redirect()->route('login.create');
});
Route::middleware(['guest'])->group(function (){
    Route::get('/register', [\App\Http\Controllers\RegisterController::class, 'create'])->name('register.create');
    Route::post('/register', [\App\Http\Controllers\RegisterController::class, 'store'])->name('register.store');

    Route::get('/login', [\App\Http\Controllers\LoginController::class, 'create'])->name('login.create');
    Route::post('/login', [\App\Http\Controllers\LoginController::class, 'store'])->name('login.store');

    Route::get('/forgot-password', [\App\Http\Controllers\LoginController::class, 'create'])->name('forgot-password.create');
});

Route::middleware(['auth'])->group(function (){
    Route::post('/logout', [\App\Http\Controllers\LoginController::class, 'destroy'])->name('logout');
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    Route::get('/subscription/plan', [\App\Http\Controllers\SubscriptionController::class, 'index'])->name('subscription.index');
    Route::get('/subscription/{plan}', [\App\Http\Controllers\SubscriptionController::class, 'create'])->name('subscription.create');
    Route::post('/subscription', [\App\Http\Controllers\SubscriptionController::class, 'store'])->name('subscription.store');


});
