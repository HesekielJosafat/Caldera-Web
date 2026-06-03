<?php

namespace App\Providers;

use Google_Client;
use Google_Service_Gmail;
use Illuminate\Support\ServiceProvider;

class GoogleApiServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(Google_Client::class, function ($app) {
            $client = new Google_Client();
            $client->setApplicationName(config('app.name'));
            $client->setScopes([Google_Service_Gmail::GMAIL_SEND]);
            $client->setAuthConfig(storage_path('app/google-calendar-oauth.json'));
            $client->setAccessType('offline');
            $client->setPrompt('select_account consent');
            return $client;
        });

        $this->app->singleton(Google_Service_Gmail::class, function ($app) {
            return new Google_Service_Gmail($app->make(Google_Client::class));
        });
    }

    public function boot(): void
    {
        //
    }
}