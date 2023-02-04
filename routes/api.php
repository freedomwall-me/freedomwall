<?php

use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Auth\CsrfController;
use App\Http\Controllers\WallController;
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

Route::prefix("auth")->group(function () {
    Route::get("csrf-cookie", [CsrfController::class, "show"])
        ->middleware("web")
        ->name("auth.csrf-cookie");

    Route::post("login", [AuthenticationController::class, "login"])->name(
        "auth.login"
    );
    Route::post("register", [
        AuthenticationController::class,
        "register",
    ])->name("auth.register");

    // protected
    // %{

    Route::post("logout", [AuthenticationController::class, "logout"])->name(
        "auth.logout"
    );

    Route::post("verify/email", [
        VerificationController::class,
        "resend",
    ])->name("auth.verify.email");
    Route::get("verify/{id}/{hash}", [
        VerificationController::class,
        "verify",
    ])->name("auth.verify");

    // password reset
    Route::get("reset-password/{hash}", [
        ResetPasswordController::class,
        "reset",
    ])->name("auth.reset-password");

    // }%
});

Route::get("walls", [WallController::class, "index"])->name("wall.index");
Route::get("wall/{wall}", [WallController::class, "show"])->name("wall.show");

Route::apiResource("wall", WallController::class)
    ->middleware("auth:sanctum")
    ->middleware("verified")
    ->only(["store", "update", "destroy"]);
