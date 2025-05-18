<?php

namespace App\Http\Controllers;

use App\Models\EventPengembanganKarir;
use App\Models\PendaftaranEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PendaftaranEventController extends Controller
{
    /**
     * Alumni mendaftar ke event.
     */
  public function register(EventPengembanganKarir $event)
{
    $user = Auth::user();
    // 1. Hanya alumni approved
    if ($user->role !== 'alumni' || $user->status !== 'approved') {
        return back()->withErrors('Hanya alumni approved yang bisa mendaftar.');
    }

    // 2. Cek window tanggal
    $now = now();
    if ($now->lt($event->tanggal_mulai) || $now->gt($event->tanggal_akhir_pendaftaran)) {
        return back()->withErrors('Pendaftaran di luar periode yang ditentukan.');
    }

    // 3. Duplikat
    $exists = PendaftaranEvent::where('event_id', $event->id)
               ->where('user_id', $user->id)
               ->exists();
    if ($exists) {
        return back()->withErrors('Anda sudah mendaftar event ini.');
    }

    // 4. Kuota
    $jumlahPendaftar = PendaftaranEvent::where('event_id', $event->id)
        ->whereIn('status', ['menunggu','berhasil'])
        ->count();
    if ($jumlahPendaftar >= $event->maksimal_peserta) {
        return back()->withErrors('Kuota pendaftaran sudah penuh.');
    }

    // 5. Simpan
    PendaftaranEvent::create([
        'event_id' => $event->id,
        'user_id'  => $user->id,
        'status'   => 'menunggu',
    ]);

    return back()->with('success', 'Pendaftaran berhasil. Silakan lanjutkan pembayaran.');
}

}
