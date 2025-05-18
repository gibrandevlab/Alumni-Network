<?php

namespace App\Http\Controllers;

use App\Models\PembayaranEvent;
use App\Models\PendaftaranEvent;
use Illuminate\Http\Request;

class PembayaranEventController extends Controller
{
    public function callback(Request $request)
    {
        $serverKey    = config('midtrans.server_key');
        $signatureKey = hash(
            'sha512',
            $request->order_id .
            $request->status_code .
            $request->gross_amount .
            $serverKey
        );

        if ($signatureKey !== $request->signature_key) {
            return response()->json(['status' => 'invalid signature'], 400);
        }

        $pendaftaran = PendaftaranEvent::where('id', explode('-', $request->order_id)[0])->first();
        if (! $pendaftaran) {
            return response()->json(['status' => 'order not found'], 404);
        }

        // update atau buat record pembayaran_event
        $pembayaran = PembayaranEvent::updateOrCreate(
            ['pendaftaran_event_id' => $pendaftaran->id],
            [
                'status_pembayaran'     => $request->transaction_status,
                'midtrans_transaction_id' => $request->transaction_id,
                'jumlah'                => $request->gross_amount,
                'waktu_pembayaran'      => now(),
            ]
        );

        return response()->json(['status' => 'success']);
    }
}
