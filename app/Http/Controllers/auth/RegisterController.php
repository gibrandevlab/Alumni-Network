<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ProfilAlumni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('pages.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'alumni',
            'status' => 'pending',
        ]);

        ProfilAlumni::create([
            'user_id' => $user->id,
        ]);

        Auth::login($user);
        
        return redirect('/profile/create')->with('success', 'Registrasi berhasil! Silakan lengkapi profil Anda.');
    }

    // Redirect ke Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Callback dari Google
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::firstOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'password' => Hash::make(uniqid()), // Generate password acak
                    'role' => 'alumni',
                    'status' => 'pending',
                ]
            );

            ProfilAlumni::Create([
                'user_id' => $user->id,
            ]);

            // Login user setelah registrasi
            Auth::login($user);

            return redirect()->route('login')->with('success', 'Login dengan Google berhasil!');
        } catch (\Exception $e) {
            return redirect()->route('register')->with('error', 'Terjadi kesalahan saat login dengan Google.');
        }
    }
}
