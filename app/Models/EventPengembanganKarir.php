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
        'status',
        'tipe_event',
        'judul_event',
        'deskripsi_event',
        'tanggal_mulai',
        'tanggal_akhir_pendaftaran',
        'dilaksanakan_oleh',
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

    public static function rules($tipe = 'event') {
        $base = [
            'judul_event' => 'required|string|max:255',
            'dilaksanakan_oleh' => 'required|string|max:100',
            'foto' => 'nullable|image|max:2048',
            'link' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif',
        ];
        if ($tipe === 'event') {
            $base = array_merge($base, [
                'deskripsi_event' => 'required|string',
                'tanggal_mulai' => 'required|date',
                'tanggal_akhir_pendaftaran' => 'required|date|after_or_equal:tanggal_mulai',
                'harga_daftar' => 'required|integer',
                'maksimal_peserta' => 'required|integer',
            ]);
        } else {
            $base['deskripsi_event'] = 'nullable|string';
            $base['tanggal_mulai'] = 'nullable|date';
            $base['tanggal_akhir_pendaftaran'] = 'nullable|date';
            $base['harga_daftar'] = 'nullable|integer';
            $base['maksimal_peserta'] = 'nullable|integer';
        }
        return $base;
    }

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

    public function pendaftarans() {
        return $this->hasMany(PendaftaranEvent::class, 'event_id');
    }
}

