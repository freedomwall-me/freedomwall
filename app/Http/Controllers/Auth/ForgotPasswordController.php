<?php

namespace App\Http\Controllers\Auth;

use App\Http\HttpResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends BaseController
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;
    use HttpResponse;

    // override the sendResetLinkEmail method
    public function sendResetLinkEmail(\Illuminate\Http\Request $request)
    {
        $this->validateEmail($request);

        $response = $this->broker()->sendResetLink(
            $this->credentials($request)
        );

        return $response == \Password::RESET_LINK_SENT
                    ? $this->success('Password reset link sent successfully.')
                    : $this->error('Failed to send password reset link.', [], 400);
    }
}
