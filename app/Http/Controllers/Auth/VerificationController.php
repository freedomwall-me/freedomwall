<?php

namespace App\Http\Controllers\Auth;

use App\Http\HttpResponse;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\VerifiesEmails;

class VerificationController extends BaseController
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;
    use HttpResponse;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware("auth:sanctum");
        $this->middleware("signed")->only("verify");
        $this->middleware("throttle:6,1")->only("verify", "resend");
    }

    // override the resend method
    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return $this->error("Email already verified.", [], 422);
        }

        $request->user()->sendEmailVerificationNotification();

        return $this->success("Verification link sent successfully.");
    }

    // override the verify method
    public function verify(Request $request)
    {
        if (
            !hash_equals(
                (string) $request->route("id"),
                (string) $request->user()->getKey()
            )
        ) {
            return $this->error("Unauthorized email verification.", [], 401);
        }

        if (
            !hash_equals(
                (string) $request->route("hash"),
                sha1($request->user()->getEmailForVerification())
            )
        ) {
            return $this->error("Signature does not match.", [], 401);
        }

        if ($request->user()->hasVerifiedEmail()) {
            return $this->error("Email already verified.", [], 422);
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        if ($response = $this->verified($request)) {
            return $response;
        }

        return $this->success("Email verified successfully.");
    }
}
