<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Tampilkan halaman profil dengan data pengguna dan relasinya.
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        /** @var User $user */
        $user = Auth::user();

        // Hanya izinkan user dengan status pending atau approved
        if (!in_array($user->status, ['approved', 'pending'])) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Akun Anda tidak diizinkan mengakses profil.');
        }

        // Load relasi sesuai role
        $user->load([
            $user->role === 'admin' ? 'profilAdmin' : 'profilAlumni'
        ]);

        // Ambil data profil via accessor
        $profileData = $user->profil();

        return view('pages.Profile', compact('user', 'profileData'));
    }

    /**
     * Simpan atau update data profil berdasarkan role user.
     */
    public function store(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        if (!$user || !in_array($user->status, ['approved', 'pending'])) {
            return redirect()->route('login')->with('error', 'Akses tidak valid atau akun Anda ditolak.');
        }

        // Validasi dan update user
        $request->validate([
            'nama'  => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'foto'  => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle file upload for foto
        $fotoPath = $user->foto; // Default to existing foto
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $fotoPath = $foto->storeAs('profile_pictures', uniqid() . '.' . $foto->getClientOriginalExtension(), 'public');
        }

        $user->update([
            'nama'  => $request->input('nama'),
            'email' => $request->input('email'),
            'foto'  => $fotoPath,
        ]);

        // Simpan profil sesuai role
        if ($user->role === 'admin') {
            $request->validate([
                'no_telepon' => 'required|digits_between:10,15',
                'jabatan'    => 'required|string|max:100',
            ]);

            $user->profilAdmin()->updateOrCreate(
                ['user_id' => $user->id],
                $request->only('no_telepon', 'jabatan')
            );

        } elseif ($user->role === 'alumni') {
            $request->validate([
                'nim'             => 'nullable|string|max:50',
                'jurusan'         => 'nullable|string|max:100',
                'no_telepon'      => 'required|digits_between:10,15',
                'alamat_rumah'    => 'required|string|max:255',
                'linkedin'        => 'nullable|url|max:255',
                'instagram'       => 'nullable|string|max:100',
                'email_alternatif'=> 'nullable|email|max:255',
            ]);

            $user->profilAlumni()->updateOrCreate(
                ['user_id' => $user->id],
                $request->only([
                    'nim', 'jurusan', 'no_telepon', 'alamat_rumah',
                    'linkedin', 'instagram', 'email_alternatif'
                ])
            );

        } else {
            return redirect()->route('profile.index')->with('error', 'Role pengguna tidak dikenali.');
        }

        return redirect()->route('profile.index')->with('success', 'Profil berhasil diperbarui.');
    }
}
