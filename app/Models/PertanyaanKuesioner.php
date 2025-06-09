<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PertanyaanKuesioner extends Model
{
    protected $fillable = [
        'kuesioner_id', 'pertanyaan', 'tipe', 'skala', 'urutan'
    ];

    public function kuesioner()
    {
        return $this->belongsTo(Kuesioner::class);
    }
} 