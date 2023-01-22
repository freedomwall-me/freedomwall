<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/', [App\Http\Controllers\IndexController::class, 'home'])->name('home');
Route::get('/contact', [App\Http\Controllers\IndexController::class, 'contact'])->name('contact');
Route::get('/privacy', [App\Http\Controllers\IndexController::class, 'privacy'])->name('privacy');
Route::get('/profile', [App\Http\Controllers\IndexController::class, 'profile'])->name('profile');

Route::resource('wall', App\Http\Controllers\WallController::class);

Auth::routes();


