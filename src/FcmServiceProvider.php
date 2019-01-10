<?php

namespace Plus\Fcm;

use Illuminate\Support\ServiceProvider;

class FcmServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(MessagingClient::class, function () {
            return new MessagingClient(config('services.fcm.key'));
        });
    }
}