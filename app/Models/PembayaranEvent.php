<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PembayaranEvent extends Model
{
    // Nama tabel (opsional jika tabel mengikuti konvensi Laravel)
    protected $table = 'pembayaran_event';

    // Kolom yang dapat diisi melalui mass assignment
    protected $fillable = [
        'pendaftaran_event_id',
        'status_pembayaran',
        'midtrans_transaction_id',
        'jumlah',
        'waktu_pembayaran',
    ];

    // Status pembayaran event
    const STATUS_PENDING = 'pending';
    const STATUS_CAPTURE = 'capture';
    const STATUS_SETTLEMENT = 'settlement';
    const STATUS_DENY = 'deny';
    const STATUS_EXPIRE = 'expire';
    const STATUS_CANCEL = 'cancel';

    /**
     * Relasi ke model PendaftaranEvent.
     * Satu pembayaran_event milik satu pendaftaran_event.
     */
    public function pendaftaranEvent()
    {
        return $this->belongsTo(PendaftaranEvent::class, 'pendaftaran_event_id');
    }
}
