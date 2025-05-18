<?php

namespace App\Http\Controllers;

use App\Models\PendaftaranEvent;
use Illuminate\Http\Request;
use Midtrans\Snap;
use Midtrans\Config;

class PaymentGatewayController extends Controller
{
    public function __construct()
    {
        Config::$isProduction = config('midtrans.is_production');
        Config::$serverKey    = config('midtrans.server_key');
        Config::$isSanitized  = config('midtrans.is_sanitized');
        Config::$is3ds        = config('midtrans.is_3ds');
    }

    public function getSnapToken(Request $request)
    {
        $req = $request->validate([
            'pendaftaran_event_id' => 'required|exists:pendaftaran_event,id',
        ]);

        $pendaftaran = PendaftaranEvent::findOrFail($req['pendaftaran_event_id']);

        $params = [
            'transaction_details' => [
                'order_id'     => 'PE'.$pendaftaran->id.'-'.time(),
                'gross_amount' => $pendaftaran->event->harga_daftar ?? 0,
            ],
            'customer_details' => [
                'first_name' => $pendaftaran->user->nama,
                'email'      => $pendaftaran->user->email,
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        // simpan snap_token ke pembayaran_event nanti di callback
        return response()->json(['snap_token' => $snapToken]);
    }
}

