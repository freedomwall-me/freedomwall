<?php

use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\EmailController;
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
Route::get('/profile', [IndexController::class, 'profile'])->name('profile')->middleware('verified');

Route::resource('/wall', WallController::class);

Route::post('/mail-subsystem', [EmailController::class, 'store'])->name('email.store');

Route::get('/email/verify', [VerificationController::class, 'show'])
    ->middleware('auth')
    ->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])
    ->middleware(['auth', 'signed'])
    ->name('verification.verify');
Route::post('/email/verification-notification', [VerificationController::class, 'resend'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.resend');

Auth::routes(['verify' => true]);
