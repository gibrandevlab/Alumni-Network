<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ProfilAlumni; // Pastikan Anda menambahkan model ProfilAlumni
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('pages.auth.register'); // Tampilkan halaman registrasi
    }

    public function register(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6', // Validasi panjang password minimal 6 karakter
        ]);

        // Membuat pengguna baru
        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password), // Hash password
            'role' => 'alumni', // Auto fill role menjadi alumni
            'status' => 'pending', // Auto fill status menjadi pending
        ]);

        // Menyimpan ID pengguna baru ke tabel profil_alumni
        ProfilAlumni::create([
            'user_id' => $user->id, // Ambil ID pengguna yang baru dibuat
            // Tambahkan kolom lain yang diperlukan untuk profil_alumni jika ada
        ]);

        // Redirect atau memberikan notifikasi sukses
        return redirect()->route('login')->with('success', 'Registrasi berhasil. Silakan login.');
    }
}
