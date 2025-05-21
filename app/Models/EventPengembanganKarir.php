<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventPengembanganKarir extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'event_pengembangan_karir';

    protected $fillable = [
        'judul_event',
        'deskripsi_event',
        'tanggal_mulai',
        'tanggal_akhir_pendaftaran',
        'dilaksanakan_oleh',
        'tipe_event',
        'foto',
        'link',
        'harga_daftar',
        'maksimal_peserta',
    ];

    protected $dates = [
        'tanggal_mulai',
        'tanggal_akhir_pendaftaran',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $attributes = [
        'tipe_event' => 'event',
    ];

    /**
     * Scope untuk filter tipe event "loker"
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeLoker($query)
    {
        return $query->where('tipe_event', 'loker');
    }

    /**
     * Scope untuk filter tipe event "event"
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeEvent($query)
    {
        return $query->where('tipe_event', 'event');
    }
}

