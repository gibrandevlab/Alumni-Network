<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilAlumni extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'profil_alumni';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'nim',
        'jurusan',
        'tahun_masuk',
        'tahun_lulus',
        'no_telepon',
        'alamat_rumah',
        'ipk',
        'linkedin',
        'instagram',
        'email_alternatif',
    ];

    /**
     * Get the user that owns the ProfilAlumni
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
