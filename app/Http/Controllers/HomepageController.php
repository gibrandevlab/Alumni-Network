<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\EventPengembanganKarir;

class HomepageController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Ambil data event yang belum selesai
        $events = EventPengembanganKarir::where('tipe_event', 'event')
            ->whereDate('tanggal_akhir', '>=', date('Y-m-d'))
            ->select([
                'id',
                'judul_event',
                'deskripsi_event',
                'tanggal_mulai',
                'tanggal_akhir',
                'dilaksanakan_oleh',
                'tipe_event',
                'foto',
                'link',
            ])
            ->get();

        // Ambil data loker yang belum selesai
        $loker = EventPengembanganKarir::where('tipe_event', 'loker')
            ->whereDate('tanggal_akhir', '>=', date('Y-m-d'))
            ->select([
                'id',
                'judul_event',
                'deskripsi_event',
                'tanggal_mulai',
                'tanggal_akhir',
                'dilaksanakan_oleh',
                'tipe_event',
                'foto',
                'link',
            ])
            ->get();

        // Mengirimkan data ke view
        return view('pages.welcome', [
            'id' => $user?->id ?? null,
            'role' => $user?->role ?? null,
            'status' => $user?->status ?? null,
            'events' => $events,
            'loker' => $loker,
        ]);
    }
}

