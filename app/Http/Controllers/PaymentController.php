<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\PembayaranEvent;
use App\Models\PendaftaranEvent;

class PaymentController extends Controller
{
    public function handleWebhook(Request $request)
    {
        // Ambil Server Key dari config
        $serverKey = config('midtrans.server_key');

        // Validasi signature key
        $signatureKey = hash('sha512',
            $request->order_id .
            $request->status_code .
            $request->gross_amount .
            $serverKey
        );
        if ($signatureKey !== $request->signature_key) {
            Log::warning('Invalid Midtrans signature key', [
                'expected' => $signatureKey,
                'got' => $request->signature_key,
                'order_id' => $request->order_id
            ]);
            return response()->json(['message' => 'Invalid signature key'], 403);
        }

        // Ambil ID pendaftaran dari order_id (format: EVT-{id}-{timestamp})
        $parts = explode('-', $request->order_id, 3);
        $pendaftaranId = $parts[1] ?? null;
        if (!$pendaftaranId) {
            Log::warning('Invalid order_id format', ['order_id' => $request->order_id]);
            return response()->json(['message' => 'Invalid order_id'], 400);
        }

        $pembayaran = PembayaranEvent::where('pendaftaran_event_id', $pendaftaranId)->first();
        $pendaftaran = PendaftaranEvent::find($pendaftaranId);
        if (!$pembayaran || !$pendaftaran) {
            Log::warning('Data not found', ['pendaftaran_id' => $pendaftaranId]);
            return response()->json(['message' => 'Not found'], 404);
        }

        // Update status pembayaran dan pendaftaran sesuai status Midtrans
        if (in_array($request->transaction_status, ['settlement', 'capture'])) {
            $pembayaran->status_pembayaran = 'berhasil';
            $pendaftaran->status = 'berhasil';
            $pembayaran->waktu_pembayaran = now();
        } elseif (in_array($request->transaction_status, ['cancel', 'expire', 'deny'])) {
            $pembayaran->status_pembayaran = 'gagal';
            $pendaftaran->status = 'menunggu';
        } elseif ($request->transaction_status == 'pending') {
            $pembayaran->status_pembayaran = 'menunggu';
            $pendaftaran->status = 'menunggu';
        }
        $pembayaran->midtrans_transaction_id = $request->order_id;
        $pembayaran->jumlah = $request->gross_amount;
        $pembayaran->save();
        $pendaftaran->save();

        Log::info('Midtrans webhook processed', [
            'pendaftaran_id' => $pendaftaranId,
            'status' => $request->transaction_status,
            'order_id' => $request->order_id
        ]);

        return response()->json(['message' => 'Webhook processed successfully']);
    }
}
