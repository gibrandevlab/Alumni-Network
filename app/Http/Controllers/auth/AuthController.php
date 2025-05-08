<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    private const MAX_LOGIN_ATTEMPTS = 5; // Maksimal percobaan login
    private const DECAY_MINUTES = 15; // Waktu blokir dalam menit

    public function showLoginForm()
    {
        if (Auth::check()) {
            return match (Auth::user()->role) {
                'admin' => redirect()->route('dashboard.dashboard'),
                'alumni' => redirect()->route('homepage.index'),
                default => redirect()->route('homepage.index'),
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

        $throttleKey = $this->throttleKey($request);

        if (RateLimiter::tooManyAttempts($throttleKey, self::MAX_LOGIN_ATTEMPTS)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return redirect()->back()->withInput()->with(
                'notif_login',
                "Terlalu banyak percobaan login. Silakan coba lagi dalam " . ceil($seconds / 60) . " menit."
            );
        }

        $user = User::where('email', $request->input('email'))->first();

        if ($this->attemptLogin($user, $request->input('password'))) {
            RateLimiter::clear($throttleKey); // Reset percobaan login jika berhasil
            return $this->handleUserStatus($request, $user);
        }

        RateLimiter::hit($throttleKey, self::DECAY_MINUTES * 60); // Tambahkan percobaan login
        $remainingAttempts = self::MAX_LOGIN_ATTEMPTS - RateLimiter::attempts($throttleKey);

        return $this->handleFailedLogin($request, "Email atau password salah. Percobaan login tersisa: $remainingAttempts.");
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
            return redirect()->route('profile.create');
        }

        if ($user->status === 'rejected') {
            return $this->handleFailedLogin($request, 'Akun Anda telah ditolak. Silakan hubungi admin untuk informasi lebih lanjut.');
        }

        Auth::login($user);
        $request->session()->regenerate();

        return match ($user->role) {
            'admin' => redirect()->route('dashboard.dashboard'),
            'alumni' => redirect()->route('homepage.index'),
            default => redirect()->route('homepage.index'),
        };
    }

    private function throttleKey(Request $request): string
    {
        return Str::lower($request->input('email')) . '|' . $request->ip();
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
                'admin' => redirect()->route('dashboard.dashboard'),
                'alumni' => redirect()->route('homepage.index'),
                default => redirect()->route('homepage.index'),
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
        return redirect()->route('homepage.index')->with('success', 'Anda telah berhasil logout.');
    }
}

