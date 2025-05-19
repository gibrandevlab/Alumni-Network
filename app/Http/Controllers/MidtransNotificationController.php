<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config as LaravelConfig;
use App\Models\PembayaranEvent;
use App\Models\PendaftaranEvent;
use Midtrans\Config as MidtransConfig;
use Midtrans\Notification;

class MidtransNotificationController extends Controller
{
    public function handle(Request $request)
    {
        // 1. Konfigurasi Midtrans
        MidtransConfig::$serverKey    = LaravelConfig::get('services.midtrans.server_key');
        MidtransConfig::$isProduction = LaravelConfig::get('services.midtrans.is_production');
        MidtransConfig::$isSanitized  = LaravelConfig::get('services.midtrans.is_sanitized');
        MidtransConfig::$is3ds        = LaravelConfig::get('services.midtrans.is_3ds');

        // 2. Tangkap notification payload
        $notif = new Notification();
        Log::info('Midtrans notification received', $request->all());
        Log::info('Midtrans notif payload', (array)$notif);

        // 3. Verifikasi signature
        $expectedSignature = hash(
            'sha512',
            $notif->order_id . $notif->status_code . $notif->gross_amount . LaravelConfig::get('services.midtrans.server_key')
        );
        Log::info('Midtrans signature check', [
            'expected' => $expectedSignature,
            'got' => $notif->signature_key,
            'order_id' => $notif->order_id,
            'status_code' => $notif->status_code,
            'gross_amount' => $notif->gross_amount,
            'server_key' => LaravelConfig::get('services.midtrans.server_key')
        ]);
        if ($notif->signature_key !== $expectedSignature) {
            Log::warning('Midtrans signature mismatch', [
                'expected' => $expectedSignature,
                'got'      => $notif->signature_key
            ]);
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        // 4. Extract pendaftaran_id (format: EVT-{id}-{timestamp})
        $parts = explode('-', $notif->order_id, 3);
        $pendaftaranId = $parts[1] ?? null;
        if (! $pendaftaranId) {
            Log::warning('Midtrans: invalid order_id', ['order_id' => $notif->order_id]);
            return response()->json(['message' => 'Invalid order_id'], 400);
        }

        // 5. Cari record pendaftaran & pembayaran
        $pembayaran  = PembayaranEvent::where('pendaftaran_event_id', $pendaftaranId)->first();
        $pendaftaran = PendaftaranEvent::find($pendaftaranId);
        if (! $pembayaran || ! $pendaftaran) {
            Log::warning('Midtrans: data not found', ['pendaftaran_id' => $pendaftaranId]);
            return response()->json(['message' => 'Data not found'], 404);
        }

        // 6. Mapping status Midtrans ke kolom status_pembayaran
        $transactionStatus = $notif->transaction_status; // capture, settlement, pending, deny, expire, cancel

        $pembayaran->midtrans_transaction_id = $notif->order_id;
        $pembayaran->jumlah                 = $notif->gross_amount;
        $pembayaran->waktu_pembayaran       = now();
        $pembayaran->status_pembayaran      = $transactionStatus;

        // 7. Update status pendaftaran hanya jika sukses
        if (in_array($transactionStatus, ['capture', 'settlement'], true)) {
            $pendaftaran->status = 'berhasil';
        } else {
            $pendaftaran->status = 'menunggu';
        }

        // 8. Simpan perubahan
        $pembayaran->save();
        $pendaftaran->save();

        Log::info('Midtrans: status updated', [
            'pendaftaran_id'     => $pendaftaranId,
            'transactionStatus'  => $transactionStatus,
            'order_id'           => $notif->order_id,
        ]);

        return response()->json(['message' => 'OK']);
    }

    public function finish(Request $request)
    {
        $orderId = $request->query('order_id');
        $statusPembayaran = null;
        $statusPendaftaran = null;
        $pembayaran = null;
        $pendaftaran = null;
        if ($orderId) {
            $parts = explode('-', $orderId, 3);
            $pendaftaranId = $parts[1] ?? null;
            if ($pendaftaranId) {
                $pembayaran = \App\Models\PembayaranEvent::where('pendaftaran_event_id', $pendaftaranId)->first();
                $pendaftaran = \App\Models\PendaftaranEvent::find($pendaftaranId);
                $statusPembayaran = $pembayaran ? $pembayaran->status_pembayaran : null;
                $statusPendaftaran = $pendaftaran ? $pendaftaran->status : null;
            }
        }
        return view('event.user.midtrans-finish', compact('statusPembayaran', 'statusPendaftaran', 'pembayaran', 'pendaftaran'));
    }

    public function unfinish(Request $request)
    {
        $orderId = $request->query('order_id');
        $statusPembayaran = null;
        $statusPendaftaran = null;
        $pembayaran = null;
        $pendaftaran = null;
        if ($orderId) {
            $parts = explode('-', $orderId, 3);
            $pendaftaranId = $parts[1] ?? null;
            if ($pendaftaranId) {
                $pembayaran = \App\Models\PembayaranEvent::where('pendaftaran_event_id', $pendaftaranId)->first();
                $pendaftaran = \App\Models\PendaftaranEvent::find($pendaftaranId);
                $statusPembayaran = $pembayaran ? $pembayaran->status_pembayaran : null;
                $statusPendaftaran = $pendaftaran ? $pendaftaran->status : null;
            }
        }
        return view('event.user.midtrans-unfinish', compact('statusPembayaran', 'statusPendaftaran', 'pembayaran', 'pendaftaran'));
    }

    public function error(Request $request)
    {
        $orderId = $request->query('order_id');
        $statusPembayaran = null;
        $statusPendaftaran = null;
        $pembayaran = null;
        $pendaftaran = null;
        if ($orderId) {
            $parts = explode('-', $orderId, 3);
            $pendaftaranId = $parts[1] ?? null;
            if ($pendaftaranId) {
                $pembayaran = \App\Models\PembayaranEvent::where('pendaftaran_event_id', $pendaftaranId)->first();
                $pendaftaran = \App\Models\PendaftaranEvent::find($pendaftaranId);
                $statusPembayaran = $pembayaran ? $pembayaran->status_pembayaran : null;
                $statusPendaftaran = $pendaftaran ? $pendaftaran->status : null;
            }
        }
        return view('event.user.midtrans-error', compact('statusPembayaran', 'statusPendaftaran', 'pembayaran', 'pendaftaran'));
    }
}
