<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventKuesioner extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'event_kuesioner';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'judul_event',
        'deskripsi_event',
        'foto',
        'tahun_mulai',
        'tahun_akhir',
        'tahun_lulusan',
        'target_peserta',
    ];

    // Relasi: EventKuesioner hasMany PertanyaanKuesioner
    public function pertanyaan()
    {
        return $this->hasMany(\App\Models\PertanyaanKuesioner::class, 'event_kuesioner_id');
    }
}
