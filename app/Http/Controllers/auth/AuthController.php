<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return match (Auth::user()->role) {
                'admin' => redirect('/dashboard'),
                'alumni' => redirect('/'),
                default => redirect('/'),
            };
        }

        return view('pages.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            
            if ($user->status === 'pending') {
                Auth::logout();
                return redirect()->back()->with('notif_login', 'Akun Anda masih dalam status pending. Mohon tunggu persetujuan admin.');
            }

            if ($user->status === 'rejected') {
                Auth::logout();
                return redirect()->back()->with('notif_login', 'Akun Anda ditolak. Silakan hubungi admin.');
            }

            return match ($user->role) {
                'admin' => redirect()->intended('/dashboard'),
                'alumni' => redirect()->intended('/'),
                default => redirect()->intended('/'),
            };
        }

        return redirect()->back()->with('notif_login', 'Email atau password salah.');
    }

    private function attemptLogin(?User $user, string $password): bool
    {
        return $user && Hash::check($password, $user->password);
    }

    private function handleFailedLogin(Request $request, string $message)
    {
        return redirect()->back()->withInput()->with('notif_login', $message);
    }

    private function handleUserStatus(Request $request, User $user)
    {
        if ($user->status === 'pending') {
            Auth::login($user);
            $request->session()->regenerate();
            return redirect('/profile/create');
        }

        if ($user->status === 'rejected') {
            return $this->handleFailedLogin($request, 'Akun Anda telah ditolak.');
        }

        Auth::login($user);
        $request->session()->regenerate();

        return match ($user->role) {
            'admin' => redirect()->intended('/dashboard'),
            'alumni' => redirect()->intended('/'),
            default => redirect()->intended('/'),
        };
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback($request)
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::where('google_id', $googleUser->getId())->first();

            if (!$user) {
                return redirect()->route('login')->with('error', 'Akun Google Anda belum terdaftar.');
            }

            Auth::login($user);
            $request->session()->regenerate();

            return match ($user->role) {
                'admin' => redirect()->intended('/dashboard'),
                'alumni' => redirect()->intended('/'),
                default => redirect()->intended('/'),
            };
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Terjadi kesalahan saat login dengan Google.');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'Anda telah berhasil logout.');
    }
}

