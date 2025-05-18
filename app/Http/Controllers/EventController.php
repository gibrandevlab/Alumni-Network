<?php

namespace App\Http\Controllers;

use App\Models\EventPengembanganKarir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    // Halaman dashboard untuk alumni (read all)
     public function index()
    {
        // Ambil hanya event yang masih buka pendaftaran
        $events = EventPengembanganKarir::where('tanggal_akhir_pendaftaran', '>=', now())
                    ->get();

        // Render view resources/views/events/index.blade.php
        return view('events.index', compact('events'));
    }
    // Halaman dashboard untuk Admin (read all)
    public function dashboard()
    {
        $user = Auth::user();
        // Hanya Admin dengan status 'approved'
        if ($user->role !== 'admin' || $user->status !== 'approved') {
            abort(403, 'Unauthorized');
        }

        $events = EventPengembanganKarir::latest()->get();
        return view('pages.dashboard.event', compact('events'));
    }

    // Tampilkan detail untuk Admin & Alumni
    public function show(EventPengembanganKarir $event)
    {
        // siapa pun yang terlogin boleh lihat detail
        return view('pages.event.show', compact('event'));
    }

    public function create()
{
    return view('pages.admin.events.form', [
        'event' => new EventPengembanganKarir()
    ]);
}

public function edit(EventPengembanganKarir $event)
{
    return view('pages.admin.events.form', compact('event'));
}


    // Buat event baru — hanya Admin
    public function store(Request $request)
    {
        $user = Auth::user();
        if ($user->role !== 'admin' || $user->status !== 'approved') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $data = $request->validate([
            'judul_event'     => 'required|string',
            'deskripsi_event' => 'required|string',
            'tanggal_mulai'   => 'required|date',
            'tanggal_akhir_pendaftaran'   => 'required|date|after_or_equal:tanggal_mulai',
            'dilaksanakan_oleh' => 'required|string',
            'tipe_event'      => 'required|in:event,loker',
            'foto'            => 'nullable|url',
            'link'            => 'nullable|url',
        ]);

        $event = EventPengembanganKarir::create($data);
        return response()->json($event, 201);
    }

    // Update event — hanya Admin
    public function update(Request $request, EventPengembanganKarir $event)
    {
        $user = Auth::user();
        if ($user->role !== 'admin' || $user->status !== 'approved') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $data = $request->validate([
            'judul_event'            => 'sometimes|required|string',
            'deskripsi_event'        => 'sometimes|required|string',
            'tanggal_mulai'          => 'sometimes|required|date',
            'tanggal_akhir_pendaftaran' => 'sometimes|required|date|after_or_equal:tanggal_mulai',
            'dilaksanakan_oleh'      => 'sometimes|required|string',
            'tipe_event'             => 'sometimes|required|in:event,loker',
            'foto'                   => 'nullable|url',
            'link'                   => 'nullable|url',
            'harga_daftar'           => 'sometimes|required|integer',
            'maksimal_peserta'       => 'sometimes|required|integer',
        ]);

        $event->update($data);
        return response()->json($event);
    }

    // Hapus event — hanya Admin
    public function destroy(EventPengembanganKarir $event)
    {
        $event->delete();
        return response()->json(null, 204);
    }
}

