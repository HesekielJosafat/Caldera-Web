<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Mail\Transport\GmailApiTransport;
use Google_Client;
use Illuminate\Support\Facades\Mail;  // 🔥 INI YANG PENTING - Import Mail facade

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
            Mail::extend('gmail_api', function () {
            $client = app(Google_Client::class);
            
            // Ambil token dari session
            $token = session('google_access_token');
            if ($token) {
                $client->setAccessToken($token);
            }
            
            return new GmailApiTransport($client);
        });
    }
}
