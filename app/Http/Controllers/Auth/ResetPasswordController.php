<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Routing\Controller as BaseController;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends BaseController
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    // override the sendResetResponse method
    protected function sendResetResponse(\Illuminate\Http\Request $request, $response)
    {
        return back()->with('success', 'Your password has been reset.');
    }

    // override the sendResetFailedResponse method
    protected function sendResetFailedResponse(\Illuminate\Http\Request $request, $response)
    {
        return back()->with('error', 'Password reset failed.');
    }
}
