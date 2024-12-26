<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ProfilAlumni;

class ProfileController extends Controller
{
    /**
     * Show the form page.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function create()
    {
        if (Auth::check() && ProfilAlumni::where('user_id', Auth::id())->exists()) {
            return redirect('/')->with('info', 'Profil Anda sudah ada.');
        }

        return view('pages.Profile');
    }

    /**
     * Store the submitted form data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Menambahkan user_id dari pengguna yang sedang login
        $data = $request->all();
        $data['user_id'] = Auth::check() ? Auth::id() : null; // Mengambil ID pengguna yang sedang login jika ada

        // Simpan data ke database
        ProfilAlumni::create($data);

        // Redirect dengan pesan sukses
        return redirect('/')->with('success', 'Profil berhasil dikirim!');
    }
}

