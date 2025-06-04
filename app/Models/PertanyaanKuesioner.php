<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PertanyaanKuesioner extends Model
{
    protected $table = 'pertanyaan_kuesioner';
    protected $fillable = [
        'event_kuesioner_id',
        'kategori',
        'tipe',
        'urutan',
        'pertanyaan',
        'skala',
    ];
    protected $casts = [
        'skala' => 'array',
    ];

    // Relasi: PertanyaanKuesioner belongsTo EventKuesioner
    public function event()
    {
        return $this->belongsTo(\App\Models\EventKuesioner::class, 'event_kuesioner_id');
    }
}
