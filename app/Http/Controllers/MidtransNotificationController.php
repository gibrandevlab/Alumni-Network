<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\PendaftaranEvent;
use App\Models\PembayaranEvent;
use Midtrans\Notification;

class MidtransNotificationController extends Controller
{
    public function handle(Request $request)
    {
        // Log payload for debugging
        Log::info('⚡ Midtrans Webhook hit', ['url' => url()->current(), 'payload' => request()->all()]);

        // 1. Instansiasi dan validasi signature otomatis
        $notif = new Notification();

        // 2. Baca payload
        $transactionStatus = $notif->transaction_status;  // e.g. pending, capture, settlement, expire, deny, cancel
        $orderIdFull       = $notif->order_id;            // format: EVT-{pendaftaranId}-{timestamp}
        $fraudStatus       = $notif->fraud_status;        // e.g. accept, challenge, deny
        $transactionId     = $notif->transaction_id;
        $grossAmount       = $notif->gross_amount;

        // 3. Ekstrak ID pendaftaran
        $parts = explode('-', $orderIdFull);
        $pendaftaranId = $parts[1] ?? null;
        if (! $pendaftaranId) {
            Log::warning('Format order_id tidak valid', ['order_id' => $orderIdFull]);
            return response('OK', 200);
        }

        // 4. Ambil Eloquent models
        $pendaftaran = PendaftaranEvent::find($pendaftaranId);
        $pembayaran  = $pendaftaran?->pembayaran;  // relasi method pembayaran()
        if (! $pendaftaran || ! $pembayaran) {
            Log::warning('Data pendaftaran/pembayaran tidak ditemukan', ['id' => $pendaftaranId]);
            return response('OK', 200);
        }

        // 5. Update tabel dalam satu DB transaction “live”
        DB::transaction(function() use (
            $transactionStatus, $fraudStatus,
            $pendaftaran, $pembayaran,
            $transactionId, $grossAmount
        ) {
            $pembayaran->update([
                'status_pembayaran'       => $transactionStatus,
                'midtrans_transaction_id' => $transactionId,
                'jumlah'                  => $grossAmount,
                'waktu_pembayaran'        => now(),
            ]);

            // Jika sukses dan fraud = accept → set pendaftaran berhasil
            if (in_array($transactionStatus, ['capture','settlement'])
                && $fraudStatus === 'accept') {
                $pendaftaran->update(['status' => 'berhasil']);
            }
            // Jika gagal/expire/deny → set pendaftaran gagal
            elseif (in_array($transactionStatus, ['deny','expire','cancel'])) {
                $pendaftaran->update(['status' => 'gagal']);
            }
        });

        // 6. Balas HTTP 200 OK
        return response('OK', 200);


    }

    public function finish(Request $request)
    {
        $orderId = $request->query('order_id');
        return view('midtrans.success', compact('orderId'));
    }

    public function unfinish()
    {
        return view('midtrans.unfinish');
    }

    public function error()
    {
        return view('midtrans.error');
    }
}
