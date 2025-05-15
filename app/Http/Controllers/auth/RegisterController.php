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
            'password' => 'required|string|min:8',
        ]);

        try {
            $user = User::create([
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'alumni',
                'status' => 'pending',
            ]);

            if (!ProfilAlumni::where('user_id', $user->id)->exists()) {
                ProfilAlumni::create([
                    'user_id' => $user->id,
                ]);
            }

            return redirect()->route('login')->with('success', 'Registrasi berhasil. Silakan login.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat registrasi. Silakan coba lagi.');
        }
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::firstOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'password' => Hash::make(uniqid()), // Password random
                    'role' => 'alumni',
                    'status' => 'pending',
                ]
            );

            if (!ProfilAlumni::where('user_id', $user->id)->exists()) {
                ProfilAlumni::create([
                    'user_id' => $user->id,
                ]);
            }

            Auth::login($user);
            $request->session()->regenerate();

            return match ($user->status) {
                'pending' => redirect()->route('profile.index')->with('info', 'Lengkapi profil Anda terlebih dahulu.'),
                'rejected' => redirect()->route('login')->with('error', 'Akun Anda ditolak.'),
                default => redirect()->route('homepage.index')->with('success', 'Login dengan Google berhasil!'),
            };
        } catch (\Exception $e) {
            return redirect()->route('homepage.index')->with('error', 'Terjadi kesalahan saat login dengan Google.');
        }
    }
}
