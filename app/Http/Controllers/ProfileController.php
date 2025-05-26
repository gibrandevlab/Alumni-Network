<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Tampilkan halaman profil dengan data pengguna dan relasinya.
     * Jika diberikan parameter id, role, dan status, tampilkan profil sesuai parameter.
     */
    public function index(Request $request)
    {
        $id = $request->input('id');
        $role = $request->input('role');
        $status = $request->input('status');

        // Jika parameter dikirim manual (misal dari query string)
        if (!empty($id) && !empty($role) && !empty($status)) {
            $user = \App\Models\User::find($id);
            if (!$user) {
                return redirect()->back()->with('error', 'User tidak ditemukan.');
            }
            $profileData = $role === 'admin' ? $user->profilAdmin : $user->profilAlumni;
            return view('pages.Profile', compact('user', 'profileData', 'id', 'role', 'status'));
        }

        // Jika user sudah login, inject $id, $role, $status ke semua view
        if (Auth::check()) {
            $user = Auth::user();
            $id = $user->id;
            $role = $user->role;
            $status = $user->status;
            $profileData = $role === 'admin' ? $user->profilAdmin : $user->profilAlumni;
            // Kirim variabel ke layout
            return view('pages.Profile', compact('user', 'profileData', 'id', 'role', 'status'));
        }

        // Jika belum login
        return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
    }

    /**
     * Simpan atau update data profil berdasarkan role user.
     */
    public function store(Request $request)
    {
        $user = \App\Models\User::find(Auth::id());
        if (!$user) {
            return redirect()->route('login')->with('error', 'Akses tidak valid.');
        }

        // Validasi dan update user (readonly kecuali password)
        $request->validate([
            'nama'  => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);
        $fotoName = $user->foto;
        if ($request->hasFile('foto')) {
            $request->validate([
                'foto' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
            $fotoFile = $request->file('foto');
            $fotoName = uniqid('profile_') . '.' . $fotoFile->getClientOriginalExtension();
            $fotoFile->move(public_path('images/profil'), $fotoName);
            // Simpan nama file ke session agar bisa diambil old('foto') jika validasi gagal
            session(['old_foto' => $fotoName]);
        } else if (session('old_foto')) {
            $fotoName = session('old_foto');
        }
        $user->nama = $request->input('nama');
        $user->email = $request->input('email');
        $user->foto = $fotoName;
        // Update password jika diisi
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'required|string|min:6|confirmed',
            ]);
            $user->password = bcrypt($request->input('password'));
        }
        $user->save();
        session()->forget('old_foto');

        if ($user->role === 'admin') {
            $request->validate([
                'no_telepon' => 'required|string|max:20',
                'jabatan'    => 'required|string|max:100',
            ]);
            \App\Models\ProfilAdmin::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'no_telepon' => $request->input('no_telepon'),
                    'jabatan'    => $request->input('jabatan'),
                    'nama'       => $user->nama,
                    'email'      => $user->email,
                ]
            );
        } else {
            $request->validate([
                'nim'             => 'required|string|max:50',
                'jurusan'         => 'required|string|max:100',
                'tahun_masuk'     => 'required|integer',
                'tahun_lulus'     => 'required|integer',
                'no_telepon'      => 'required|string|max:20',
                'alamat_rumah'    => 'required|string|max:255',
                'ipk'             => 'required|numeric|min:0|max:4',
                'linkedin'        => 'nullable|url|max:255',
                'instagram'       => 'nullable|string|max:100',
                'email_alternatif' => 'nullable|email|max:255',
            ]);
            \App\Models\ProfilAlumni::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'nim'             => $request->input('nim'),
                    'jurusan'         => $request->input('jurusan'),
                    'tahun_masuk'     => $request->input('tahun_masuk'),
                    'tahun_lulus'     => $request->input('tahun_lulus'),
                    'no_telepon'      => $request->input('no_telepon'),
                    'alamat_rumah'    => $request->input('alamat_rumah'),
                    'ipk'             => $request->input('ipk'),
                    'linkedin'        => $request->input('linkedin'),
                    'instagram'       => $request->input('instagram'),
                    'email_alternatif' => $request->input('email_alternatif'),
                    'nama'            => $user->nama,
                    'email'           => $user->email,
                ]
            );
        }
        return redirect()->route('profile.index')->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Tampilkan profil berdasarkan id, role, dan status jika ketiganya tidak kosong.
     */
    public function showByIdRoleStatus($id = null, $role = null, $status = null)
    {
        if (!empty($id) && !empty($role) && !empty($status)) {
            $user = \App\Models\User::find($id);
            if (!$user) {
                return redirect()->back()->with('error', 'User tidak ditemukan.');
            }
            $profileData = $role === 'admin' ? $user->profilAdmin : $user->profilAlumni;
            return view('pages.Profile', compact('user', 'profileData', 'id', 'role', 'status'));
        }
        return redirect()->back()->with('error', 'Parameter tidak lengkap.');
    }
}
