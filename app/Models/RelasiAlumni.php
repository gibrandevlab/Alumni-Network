<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelasiAlumni extends Model
{
    use HasFactory;

    protected $table = 'relasi_alumni';

    protected $fillable = [
        'alumni_utama_id',
        'alumni_teman_id',
        'tipe_hubungan',
        'deskripsi',
    ];

    public function alumniUtama()
    {
        return $this->belongsTo(User::class, 'alumni_utama_id');
    }

    public function alumniTeman()
    {
        return $this->belongsTo(User::class, 'alumni_teman_id');
    }

    public function profilUtama()
    {
        return $this->hasOne(ProfilAlumni::class, 'user_id', 'alumni_utama_id');
    }

    public function profilTeman()
    {
        return $this->hasOne(ProfilAlumni::class, 'user_id', 'alumni_teman_id');
    }
}
