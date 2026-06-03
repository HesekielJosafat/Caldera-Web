<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Google_Client;
use Illuminate\Http\Request;

class GmailAuthController extends Controller
{
    protected $client;

    public function __construct(Google_Client $client)
    {
        $this->client = $client;
        // Pastikan URL ini SAMA PERSIS dengan di Google Cloud Console
        $this->client->setRedirectUri('http://localhost:8000/google/callback');
    }

    public function redirectToGoogle()
    {
        $authUrl = $this->client->createAuthUrl();
        return redirect()->away($authUrl);
    }

    public function handleGoogleCallback(Request $request)
    {
        $code = $request->get('code');
        
        if (!$code) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Gagal autentikasi dengan Google');
        }

        try {
            $accessToken = $this->client->fetchAccessTokenWithAuthCode($code);
            session(['google_access_token' => $accessToken]);
            
            return redirect()->route('admin.dashboard')
                ->with('success', 'Berhasil terhubung dengan Gmail API');
        } catch (\Exception $e) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Gagal autentikasi: ' . $e->getMessage());
        }
    }

    
}