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
        $profileName = $user->profile->nama ?? $user->nama; // Ambil nama langsung dari model User atau ProfilAlumni/ProfilAdmin

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
            'media'   => 'nullable|file|mimes:jpeg,png,jpg,gif,mp4,mov|max:10240',
        ]);

        if (!$request->filled('message') && !$request->hasFile('media')) {
            return redirect()->back()->with('error', 'Pesan atau media harus diisi.');
        }

        $userId = Auth::user()->id;
        $mediaPath = null;
        $mediaType = null;

        // Proses mention dalam pesan
        $message = $request->input('message');
        if ($message) {
            $message = preg_replace_callback('/@([\w.\s]+)/', function ($matches) {
                return '<span class="mention">@' . e($matches[1]) . '</span>';
            }, $message);
        }

        if ($request->hasFile('media')) {
            $media = $request->file('media');
            $mediaType = explode('/', $media->getMimeType())[0];
            $fileName = time() . '_' . $media->getClientOriginalName();
            $mediaPath = 'images/Grupchat/' . $fileName;
            Storage::disk('public')->putFileAs('images/Grupchat', $media, $fileName);
        }

        Message::create([
            'user_id'    => $userId,
            'message'    => $message,
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

    public function searchUsers(Request $request)
    {
        $query = $request->input('query');
        $users = \App\Models\User::where('nama', 'like', "%{$query}%")
            ->take(5)
            ->get(['id', 'nama']); // Ambil kolom 'id' dan 'nama' saja
        return response()->json($users);
    }
}

