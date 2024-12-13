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
        'tanggal_akhir',
        'dilaksanakan_oleh',
        'tipe_event',
        'foto',
        'link',
    ];

    protected $dates = [
        'tanggal_mulai',
        'tanggal_akhir',
        'created_at',
        'updated_at',
        'deleted_at',
    ];


    protected $attributes = [
        'tipe_event' => 'event',
    ];


    public function scopeLoker($query)
    {
        return $query->where('tipe_event', 'loker');
    }

    public function scopeEvent($query)
    {
        return $query->where('tipe_event', 'event');
    }
}

