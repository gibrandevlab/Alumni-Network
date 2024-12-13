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
    // Tampilkan halaman login
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

    // Proses login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->input('email'))->first();

        if ($this->attemptLogin($user, $request->input('password'))) {
            return $this->handleUserStatus($request, $user);
        }

        return $this->handleFailedLogin($request, 'Email atau password salah.');
    }

    // Cek kredensial login
    private function attemptLogin(?User $user, string $password): bool
    {
        return $user && Hash::check($password, $user->password);
    }

    // Penanganan login gagal
    private function handleFailedLogin(Request $request, string $message)
    {
        return redirect()->back()->withInput()->with('notif_login', $message);
    }

    // Penanganan status user setelah login
    private function handleUserStatus(Request $request, User $user)
    {
        if ($user->status === 'pending') {
            return $this->handleFailedLogin($request, 'Akun Anda sedang dalam proses persetujuan.');
        }

        if ($user->status === 'rejected') {
            return $this->handleFailedLogin($request, 'Akun Anda telah ditolak.');
        }

        // Login pengguna
        Auth::login($user);
        $request->session()->regenerate();

        // Arahkan berdasarkan role
        return match ($user->role) {
            'admin' => redirect()->intended('/dashboard'),
            'alumni' => redirect()->intended('/'),
            default => redirect()->intended('/'),
        };
    }

    // Redirect ke Google untuk login
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Callback setelah login dengan Google
    public function handleGoogleCallback($request)
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Cek apakah user sudah terdaftar
            $user = User::where('google_id', $googleUser->getId())->first();

            if (!$user) {
                // Jika user belum terdaftar
                return redirect()->route('login')->with('error', 'Akun Google Anda belum terdaftar.');
            }

            // Login pengguna
            Auth::login($user);
            $request->session()->regenerate();

            // Arahkan berdasarkan role
            return match ($user->role) {
                'admin' => redirect()->intended('/dashboard'),
                'alumni' => redirect()->intended('/'),
                default => redirect()->intended('/'),
            };
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Terjadi kesalahan saat login dengan Google.');
        }
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'Anda telah berhasil logout.');
    }
}

