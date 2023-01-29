<?php

use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\WallController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/auth/login', [AuthenticationController::class, 'login'])->name('auth.login');
Route::post('/auth/register', [AuthenticationController::class, 'register'])->name('auth.register');

Route::get('/walls', [WallController::class, 'index'])->name('wall.index');
Route::get('/wall/{wall}', [WallController::class, 'show'])->name('wall.show');

Route::get('/auth/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('auth.verify');

Route::post('/auth/verify/email', [VerificationController::class, 'resend'])->name('auth.verify.email');

// password reset
Route::get('/auth/reset-password/{hash}', [ResetPasswordController::class, 'reset'])->name('auth.reset-password');

Route::post('/auth/logout', [AuthenticationController::class, 'logout'])
    ->middleware('auth:sanctum')
    ->name('auth.logout');

Route::apiResource('wall', WallController::class)
    ->middleware('auth:sanctum')
    ->middleware('verified')
    ->only(['store', 'update', 'destroy']);
