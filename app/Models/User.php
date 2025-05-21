<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'role',
        'status',
        'foto',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relasi ke ProfilAlumni
    public function profilAlumni()
    {
        return $this->hasOne(ProfilAlumni::class, 'user_id');
    }

    // Relasi ke ProfilAdmin
    public function profilAdmin()
    {
        return $this->hasOne(ProfilAdmin::class, 'user_id');
    }

    // Mengambil profil berdasarkan role
    public function profil()
    {
        return $this->role === 'admin' ? $this->profilAdmin() : $this->profilAlumni();
    }
}
