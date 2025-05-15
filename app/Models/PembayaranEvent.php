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

    /**
     * Relasi ke model PendaftaranEvent.
     * Satu pembayaran_event milik satu pendaftaran_event.
     */
    public function pendaftaranEvent()
    {
        return $this->belongsTo(PendaftaranEvent::class, 'pendaftaran_event_id');
    }
}
