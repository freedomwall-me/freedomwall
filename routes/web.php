<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\WallController;
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

Route::get('/', [IndexController::class, 'home'])->name('home');
Route::get('/contact', [IndexController::class, 'contact'])->name('contact');
Route::get('/privacy', [IndexController::class, 'privacy'])->name('privacy');
Route::get('/profile', [IndexController::class, 'profile'])->name('profile');

Route::resource('/wall', WallController::class);

Auth::routes();
