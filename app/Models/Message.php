<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    // Kolom yang dapat diisi secara massal
    protected $fillable = [
        'user_id',
        'message',
        'media_path',
        'media_type',
        'mentioned_user_id',
    ];

    /**
     * Relasi ke User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Mentioned User.
     */
    public function mentionedUser()
    {
        return $this->belongsTo(User::class, 'mentioned_user_id')->withDefault();
    }
}

