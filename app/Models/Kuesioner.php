<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kuesioner extends Model
{
    protected $fillable = [
        'judul', 'deskripsi', 'tahun_mulai', 'tahun_akhir', 'status'
    ];

    public function pertanyaan()
    {
        return $this->hasMany(PertanyaanKuesioner::class);
    }

    public function respon()
    {
        return $this->hasMany(ResponKuesioner::class);
    }
} 