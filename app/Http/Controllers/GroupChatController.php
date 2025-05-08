<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class GroupChatController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $profileName = $user->nama; // Ambil nama langsung dari model User

        // Debugging
        logger()->info('User ID:', ['id' => $user->id, 'role' => $user->role]);
        logger()->info('Profile Name:', ['name' => $profileName]);

        $messages = Message::with('user')->orderBy('created_at', 'asc')->get();

        return view('pages.groupchat', compact('messages', 'profileName'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'message' => 'nullable|string|max:1000',
            'media'   => 'nullable|file|mimes:jpeg,png,jpg,gif,mp4,mov|max:10240', // Maksimal 10MB
        ]);

        if (!$request->filled('message') && !$request->hasFile('media')) {
            return redirect()->back()->with('error', 'Pesan atau media harus diisi.');
        }

        $userId = Auth::user()->id;
        $mediaPath = null;
        $mediaType = null;

        if ($request->hasFile('media')) {
            $media = $request->file('media');
            $mediaType = explode('/', $media->getMimeType())[0];

            // Validasi ukuran berdasarkan tipe media
            if ($mediaType === 'image' && $media->getSize() > 1024 * 1024) { // 1MB untuk foto
                return redirect()->back()->with('error', 'Ukuran foto tidak boleh lebih dari 1MB.');
            }

            if ($mediaType === 'video' && $media->getSize() > 10 * 1024 * 1024) { // 10MB untuk video
                return redirect()->back()->with('error', 'Ukuran video tidak boleh lebih dari 10MB.');
            }

            $fileName = time() . '_' . $media->getClientOriginalName();
            $mediaPath = 'images/Grupchat/' . $fileName;
            Storage::disk('public')->putFileAs('images/Grupchat', $media, $fileName);
        }

        Message::create([
            'user_id'    => $userId,
            'message'    => $request->input('message'),
            'media_path' => $mediaPath,
            'media_type' => $mediaType,
        ]);

        return redirect()->back()->with('success', 'Pesan berhasil dikirim!');
    }

    public function fetchMessages()
    {
        $messages = Message::with('user')->orderBy('created_at', 'asc')->get();

        return response()->json($messages);
    }
}
