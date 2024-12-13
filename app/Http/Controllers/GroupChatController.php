<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\ProfilAdmin;
use App\Models\ProfilAlumni;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class GroupChatController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $profileName = $this->ambilNamaProfil($user->id, $user->role); // Ambil nama berdasarkan role

        // Debugging
        logger()->info('User ID:', ['id' => $user->id, 'role' => $user->role]);
        logger()->info('Profile Name:', ['name' => $profileName]);

        $messages = Message::with('user')->orderBy('created_at', 'asc')->get();

        return view('pages.groupchat', compact('messages', 'profileName'));
    }

    private function ambilNamaProfil($idPengguna, $peranPengguna)
    {
        try {
            $profilClass = $peranPengguna === 'admin' ? ProfilAdmin::class : ProfilAlumni::class;

            $profil = $profilClass::select('nama')->where('user_id', $idPengguna)->firstOrFail();

            return $profil->nama;
        } catch (ModelNotFoundException $e) {
            return 'Nama tidak ditemukan';
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'message' => 'nullable|string|max:1000',
            'media'   => 'nullable|file|mimes:jpeg,png,jpg,gif,mp4,mov|max:20480',
        ]);

        $userId = Auth::user()->id;
        $mediaPath = null;
        $mediaType = null;

        if ($request->hasFile('media')) {
            $media = $request->file('media');
            $fileName = time() . '_' . $media->getClientOriginalName();
            $mediaPath = 'images/Grupchat/' . $fileName;
            Storage::disk('public')->putFileAs('images/Grupchat', $media, $fileName);
            $mediaType = explode('/', $media->getMimeType())[0];
        }

        Message::create([
            'user_id'    => $userId,
            'message'    => $request->input('message'),
            'media_path' => $mediaPath,
            'media_type' => $mediaType,
        ]);

        return redirect()->back()->with('success', 'Pesan berhasil dikirim!');
    }
}
