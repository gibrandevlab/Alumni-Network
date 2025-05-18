<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Tampilkan halaman profil dengan data pengguna dan relasinya.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('info', 'Anda belum login.');
        }

        /** @var User $user */
        $user = Auth::user();

        // Lazy eager load relasi berdasarkan role
        $user->load($user->role === 'admin' ? 'profilAdmin' : 'profilAlumni');

        $profileData = $user->profil();

        return view('pages.Profile', compact('user', 'profileData'));
    }

    /**
     * Simpan atau update data profil berdasarkan role user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Akses tidak valid.');
        }

        // Validasi data untuk tabel users
        $request->validate([
            'nama'  => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        // Update nama & email di tabel users
        $user->update([
            'nama'  => $request->input('nama'),
            'email' => $request->input('email'),
        ]);

        // Simpan data profil sesuai role
        if ($user->role === 'admin') {
            $request->validate([
                'no_telepon' => 'required|digits_between:1,20',
                'jabatan'    => 'required|string|max:100',
            ]);

            $user->profilAdmin()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'no_telepon' => $request->input('no_telepon'),
                    'jabatan'    => $request->input('jabatan'),
                ]
            );

        } elseif ($user->role === 'alumni') {
            $request->validate([
                'no_telepon' => 'required|digits_between:1,20',
                'alamat_rumah'    => 'required|string|max:255',
                'linkedin'        => 'nullable|url',
                'instagram'       => 'nullable|string|max:100',
                'email_alternatif'=> 'nullable|email',
            ]);

            $user->profilAlumni()->updateOrCreate(
                ['user_id' => $user->id],
                $request->only([
                    'no_telepon',
                    'alamat_rumah',
                    'linkedin',
                    'instagram',
                    'email_alternatif',
                ])
            );

        } else {
            return redirect()->route('profile.index')->with('error', 'Role pengguna tidak dikenali.');
        }

        return redirect()->route('profile.index')->with('success', 'Profil berhasil disimpan!');
    }
}

