<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        Paginator::useBootstrap();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // use different verify email route
        VerifyEmail::createUrlUsing(function ($notifiable) {
            $verifyRoute = URL::temporarySignedRoute(
                "auth.verify",
                Carbon::now()->addMinutes(
                    Config::get("auth.verification.expire", 30)
                ),
                [
                    "id" => $notifiable->getKey(),
                    "hash" => sha1($notifiable->getEmailForVerification()),
                ]
            );

            $base = str_replace(url("/api"), url("/"), $verifyRoute);

            return Config::get("app.frontend") .
                "/auth/verify/" .
                urlencode($base);
        });
    }
}
