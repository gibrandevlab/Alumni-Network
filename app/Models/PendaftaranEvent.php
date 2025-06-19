<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendaftaranEvent extends Model
{
    use HasFactory;

    // Nama tabel (opsional jika tabel mengikuti konvensi Laravel)
    protected $table = 'pendaftaran_event';

    // Kolom yang dapat diisi melalui mass assignment
    protected $fillable = [
        'event_id',
        'user_id',
        'status',
        'kode_pembayaran',
        'metode_pembayaran',
    ];

    // Status pendaftaran event
    const STATUS_MENUNGGU = 'menunggu';
    const STATUS_BERHASIL = 'berhasil';

    /**
     * Relasi ke model EventPengembanganKarir.
     * Satu pendaftaran_event milik satu event.
     */
    public function event()
    {
        return $this->belongsTo(EventPengembanganKarir::class, 'event_id');
    }

    /**
     * Relasi ke model User.
     * Satu pendaftaran_event milik satu user.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi ke model PembayaranEvent.
     * Satu pendaftaran_event memiliki satu pembayaran.
     */
    public function pembayaran()
    {
        return $this->hasOne(PembayaranEvent::class, 'pendaftaran_event_id');
    }
}
