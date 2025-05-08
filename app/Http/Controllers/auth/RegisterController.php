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

        try {
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
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat registrasi. Silakan coba lagi.');
        }
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

            if (!$user->wasRecentlyCreated) {
                return redirect()->route('login')->with('info', 'Email sudah terdaftar. Silakan login.');
            }

            ProfilAlumni::create([
                'user_id' => $user->id,
            ]);

            // Login user setelah registrasi
            Auth::login($user);

            // Mengarahkan ke dashboard menggunakan route name
            return redirect()->route('dashboard.dashboard')->with('success', 'Login dengan Google berhasil!');
        } catch (\Exception $e) {
            // Mengarahkan ke homepage menggunakan route name
            return redirect()->route('homepage.index')->with('error', 'Terjadi kesalahan saat login dengan Google.');
        }
    }
}
