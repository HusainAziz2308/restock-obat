<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::updateOrCreate([
                'email' => $googleUser->getEmail(),
            ], [
                'name' => $googleUser->getName(),
                'google_id' => $googleUser->getId(),
                'email_verified_at' => now(),
            ]);

            Auth::login($user, true);

            return redirect('/admin');

        } catch (\Exception $e) {
            // SEMENTARA (buat testing)
            // dd($e->getMessage());
            
            return redirect('/admin/login')->withErrors(['error' => 'Gagal login menggunakan Google.']);
        }
    }
}
