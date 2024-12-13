<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    // Kolom yang dapat diisi secara massal
    protected $fillable = ['user_id', 'message', 'media_path', 'media_type'];

    /**
     * Relasi ke User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Cek apakah pesan memiliki media.
     *
     * @return bool
     */
    public function hasMedia(): bool
    {
        return !is_null($this->media_path);
    }

    /**
     * Dapatkan URL media yang dapat diakses publik.
     *
     * @return string|null
     */
    public function mediaUrl(): ?string
    {
        if ($this->hasMedia()) {
            return asset('storage/' . $this->media_path);
        }

        return null;
    }
}
