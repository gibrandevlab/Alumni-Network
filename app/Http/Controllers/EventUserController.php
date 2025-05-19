<?php

namespace App\Http\Controllers;

use App\Models\EventPengembanganKarir;
use App\Models\PendaftaranEvent;
use App\Models\PembayaranEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Midtrans\Snap;
use Midtrans\Config;

class EventUserController extends Controller
{
    // Menampilkan seluruh event untuk alumni yang sudah approved
    public function index()
    {
        $user = Auth::user();
        if ($user->role !== 'alumni' || $user->status !== 'approved') {
            abort(403, 'Unauthorized');
        }
        $events = EventPengembanganKarir::orderByDesc('created_at')->get();
        return view('event.user.index', compact('events'));
    }

    // Menampilkan halaman order tiket event
    public function order($eventId)
    {
        $user = Auth::user();
        if ($user->role !== 'alumni' || $user->status !== 'approved') {
            abort(403, 'Unauthorized');
        }
        $event = EventPengembanganKarir::findOrFail($eventId);
        return view('event.user.order', compact('event'));
    }

    // Proses pendaftaran dan pembayaran event
    public function daftar(Request $request, $eventId)
    {
        $user = Auth::user();
        if ($user->role !== 'alumni' || $user->status !== 'approved') {
            abort(403, 'Unauthorized');
        }
        $event = EventPengembanganKarir::findOrFail($eventId);
        // Cek jika sudah pernah daftar
        $sudahDaftar = PendaftaranEvent::where('event_id', $event->id)->where('user_id', $user->id)->first();
        if ($sudahDaftar) {
            // Jika sudah daftar, cek pembayaran jika ada
            $pembayaran = PembayaranEvent::where('pendaftaran_event_id', $sudahDaftar->id)->first();
            if ($event->harga_daftar > 0 && $pembayaran) {
                // Sudah ada pembayaran, arahkan ke halaman bayar
                // Generate snap token baru agar bisa bayar ulang jika sebelumnya gagal
                Config::$serverKey = config('midtrans.server_key');
                Config::$isProduction = config('midtrans.is_production');
                Config::$isSanitized = true;
                Config::$is3ds = true;
                $params = [
                    'transaction_details' => [
                        'order_id' => 'EVT-' . $sudahDaftar->id . '-' . time(),
                        'gross_amount' => $event->harga_daftar,
                    ],
                    'customer_details' => [
                        'first_name' => $user->nama,
                        'email' => $user->email,
                    ],
                ];
                $snapToken = Snap::getSnapToken($params);
                return view('event.user.bayar', [
                    'event' => $event,
                    'pendaftaran' => $sudahDaftar,
                    'snapToken' => $snapToken
                ]);
            }
            // Jika belum ada pembayaran, arahkan ke order
            return view('event.user.order', compact('event'));
        }
        DB::beginTransaction();
        try {
            $pendaftaran = PendaftaranEvent::create([
                'event_id' => $event->id,
                'user_id' => $user->id,
                'status' => $event->harga_daftar > 0 ? 'menunggu' : 'berhasil',
            ]);
            if ($event->harga_daftar > 0) {
                // Buat baris pembayaran status menunggu
                $pembayaran = PembayaranEvent::create([
                    'pendaftaran_event_id' => $pendaftaran->id,
                    'status_pembayaran' => 'menunggu',
                    'jumlah' => $event->harga_daftar,
                ]);
                // Midtrans config
                Config::$serverKey = config('midtrans.server_key');
                Config::$isProduction = config('midtrans.is_production');
                Config::$isSanitized = true;
                Config::$is3ds = true;
                $params = [
                    'transaction_details' => [
                        'order_id' => 'EVT-' . $pendaftaran->id . '-' . time(),
                        'gross_amount' => $event->harga_daftar,
                    ],
                    'customer_details' => [
                        'first_name' => $user->nama,
                        'email' => $user->email,
                    ],
                ];
                $snapToken = Snap::getSnapToken($params);
                DB::commit();
                return view('event.user.bayar', compact('event', 'pendaftaran', 'snapToken'));
            } else {
                DB::commit();
                return redirect()->route('event.user.index')->with('success', 'Pendaftaran berhasil tanpa pembayaran!');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
