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
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'alumni',
            'status' => 'pending',
        ]);

        ProfilAlumni::create([
            'user_id' => $user->id,
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil. Silakan login.');
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
