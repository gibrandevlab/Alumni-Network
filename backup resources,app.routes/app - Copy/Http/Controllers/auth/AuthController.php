<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('pages.auth.login');
    }


    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->input('email'))->first();

        if ($user) {
            if (!Hash::check($request->input('password'), $user->password)) {
                return $this->handleFailedLogin($request, 'Password salah.');
            }

            return $this->handleUserStatus($request, $user);
        }

        return $this->handleFailedLogin($request, 'Email tidak terdaftar.');
    }

    private function handleFailedLogin(Request $request, string $message)
    {
        $request->session()->put('notif_loginn', $message);
        return redirect()->back()->withErrors(['email' => $message]);
    }

    private function handleUserStatus(Request $request, User $user)
    {
        switch ($user->status) {
            case 'pending':
                return $this->handleFailedLogin($request, 'Akun Anda membutuhkan persetujuan administrator.');
            case 'rejected':
                return $this->handleFailedLogin($request, 'Akun Anda tidak disetujui, hubungi administrator.');
            case 'approved':
                Auth::login($user);
                $this->storeUserSession($user);
                return redirect()->intended('/dashboard');
            default:
                return $this->handleFailedLogin($request, 'Status akun tidak valid.');
        }
    }

    private function storeUserSession(User $user)
    {
        session([
            'user_id' => encrypt($user->id),      // Menyimpan id user
            'user_role' => encrypt($user->role),  // Menyimpan role user
            'user_status' => encrypt($user->status) // Menyimpan status user
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->flush(); // Menghapus semua data session saat logout
        return redirect('/')->with('success', 'Anda telah berhasil logout.');
    }
}
