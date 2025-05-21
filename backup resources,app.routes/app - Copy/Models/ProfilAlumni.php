<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilAlumni extends Model
{
    use HasFactory;

    protected $table = 'profil_alumni';

    protected $fillable = [
        'user_id', 'nama_lengkap', 'nim', 'jurusan', 'tahun_masuk', 'tahun_lulus', 'ipk', 'no_telepon', 'alamat_rumah', 'linkedin', 'instagram', 'email_alternatif'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}