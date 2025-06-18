<?php

namespace App\Http\Controllers;

use App\Models\EventPengembanganKarir;
use Illuminate\Support\Facades\Auth;

class AlumniWorkshopController extends Controller
{
    // Menampilkan daftar workshop/event untuk alumni (hanya yang aktif)
    public function index()
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'alumni' || $user->status !== 'approved') {
            abort(403, 'Unauthorized');
        }
        $workshops = EventPengembanganKarir::where('status', 'aktif')->orderByDesc('created_at')->get();
        return view('alumni.workshop', compact('workshops'));
    }

    // Menampilkan detail workshop berdasarkan id
    public function show($id)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'alumni' || $user->status !== 'approved') {
            abort(403, 'Unauthorized');
        }
        $workshop = \App\Models\EventPengembanganKarir::where('status', 'aktif')->findOrFail($id);
        return view('alumni.workshop-detail', compact('workshop'));
    }
}
