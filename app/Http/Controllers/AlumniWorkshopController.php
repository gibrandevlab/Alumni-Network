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

    // Alumni mendaftar event
    public function daftar($id)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'alumni' || $user->status !== 'approved') {
            abort(403, 'Unauthorized');
        }
        $event = EventPengembanganKarir::where('status', 'aktif')->findOrFail($id);
        $pendaftaran = \App\Models\PendaftaranEvent::firstOrCreate([
            'event_id' => $event->id,
            'user_id' => $user->id,
        ], [
            'status' => 'menunggu',
        ]);
        return redirect()->route('alumni.workshop.bayar.form', $event->id)->with('success', 'Berhasil mendaftar, silakan lanjutkan pembayaran.');
    }

    // Form pembayaran event
    public function bayarForm($id)
    {
        $user = Auth::user();
        $event = EventPengembanganKarir::findOrFail($id);
        $pendaftaran = \App\Models\PendaftaranEvent::where('event_id', $id)->where('user_id', $user->id)->first();
        if (!$pendaftaran) {
            return redirect()->route('alumni.workshop.show', $id)->with('error', 'Anda belum mendaftar event ini.');
        }
        return view('alumni.bayar-event', compact('event', 'pendaftaran'));
    }

    // Proses pembayaran event (redirect ke simulator)
    public function bayarProses($id)
    {
        $user = Auth::user();
        $event = EventPengembanganKarir::findOrFail($id);
        $pendaftaran = \App\Models\PendaftaranEvent::where('event_id', $id)->where('user_id', $user->id)->first();
        if (!$pendaftaran) {
            return redirect()->route('alumni.workshop.show', $id)->with('error', 'Anda belum mendaftar event ini.');
        }
        // Simulasi: redirect ke halaman simulator dengan kode VA boongan
        $va = '9999' . str_pad($pendaftaran->id, 8, '0', STR_PAD_LEFT);
        return redirect()->route('alumni.simulator.form')->with([
            'event_id' => $event->id,
            'pendaftaran_id' => $pendaftaran->id,
            'va' => $va,
            'nominal' => $event->harga_daftar,
        ]);
    }

    // Form simulator pembayaran
    public function simulatorPembayaranForm()
    {
        $va = session('va');
        $nominal = session('nominal');
        $pendaftaran_id = session('pendaftaran_id');
        $event_id = session('event_id');
        return view('alumni.simulator-pembayaran', compact('va', 'nominal', 'pendaftaran_id', 'event_id'));
    }

    // Proses simulator pembayaran
    public function simulatorPembayaranProses(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'kode_pembayaran' => 'required',
        ]);
        $pendaftaran = \App\Models\PendaftaranEvent::where('kode_pembayaran', $request->kode_pembayaran)->first();
        if (!$pendaftaran) {
            return back()->with('error', 'Kode pembayaran tidak ditemukan!');
        }
        $pendaftaran->status = 'berhasil';
        $pendaftaran->save();
        // update/insert ke tabel pembayaran_event
        $pembayaran = \App\Models\PembayaranEvent::updateOrCreate([
            'pendaftaran_event_id' => $pendaftaran->id,
        ], [
            'status_pembayaran' => 'settlement',
            'jumlah' => $pendaftaran->event->harga_daftar ?? 0,
            'waktu_pembayaran' => now(),
        ]);
        return redirect()->route('alumni.workshop.show', $pendaftaran->event_id)->with('success', 'Pembayaran berhasil disimulasikan!');
    }

    // AJAX: Daftar dan pilih metode pembayaran
    public function daftarAjax(\Illuminate\Http\Request $request, $id)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'alumni' || $user->status !== 'approved') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        $request->validate([
            'metode_pembayaran' => 'required|in:gopay,bca,bri',
        ]);
        $event = EventPengembanganKarir::where('status', 'aktif')->findOrFail($id);
        $kode = null;
        if ($request->metode_pembayaran === 'gopay') {
            $kode = 'GPY' . rand(10000000,99999999);
        } elseif ($request->metode_pembayaran === 'bca') {
            $kode = 'BCA' . rand(10000000,99999999);
        } elseif ($request->metode_pembayaran === 'bri') {
            $kode = 'BRI' . rand(10000000,99999999);
        }
        $pendaftaran = \App\Models\PendaftaranEvent::updateOrCreate([
            'event_id' => $event->id,
            'user_id' => $user->id,
        ], [
            'status' => 'menunggu',
            'metode_pembayaran' => $request->metode_pembayaran,
            'kode_pembayaran' => $kode,
        ]);

        // Tambahkan pembayaran_event otomatis saat pendaftaran
        \App\Models\PembayaranEvent::updateOrCreate([
            'pendaftaran_event_id' => $pendaftaran->id,
        ], [
            'status_pembayaran' => 'pending',
            'jumlah' => $event->harga_daftar,
        ]);

        return response()->json([
            'success' => true,
            'kode_pembayaran' => $kode,
            'metode_pembayaran' => $request->metode_pembayaran,
            'nominal' => $event->harga_daftar,
        ]);
    }
}
