<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EventKuesioner extends Model
{
    protected $table = 'event_kuesioner';

    protected $fillable = [
        'judul_event',
        'deskripsi_event',
        'foto',
        'tahun_mulai',
        'tahun_akhir',
        'tahun_lulusan',
        'target_peserta',
        'status' // Tambahkan field status
    ];

    public function pertanyaan(): HasMany
    {
        return $this->hasMany(PertanyaanKuesioner::class, 'event_kuesioner_id');
    }

    public function respon()
    {
        return $this->hasMany(\App\Models\ResponKuesioner::class, 'event_kuesioner_id');
    }

    // Accessor untuk status
    public function getStatusAttribute($value)
    {
        return $value ?? 'draft';
    }
}
