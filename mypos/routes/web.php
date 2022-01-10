<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Models\Client;

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
    return redirect('dashboard');
});

Auth::routes(['register' => false]);

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Dashboard Route
Route::resource('dashboard', DashboardController::class)->middleware('auth');

// User Route
Route::resource('users', UserController::class)->except('show')->middleware('auth');

// Category Route
Route::resource('categories', CategoryController::class)->except('show')->middleware('auth');

// Product Route
Route::resource('products', ProductController::class)->except('show')->middleware('auth');

// Client Route & Client Orders Route
Route::resource('clients', ClientController::class)->except('show')->middleware('auth');
Route::resource('clients.orders', App\Http\Controllers\Client\OrderController::class)->except('show')->middleware('auth');

// Order Route
Route::resource('orders', OrderController::class)->except('show')->middleware('auth');
