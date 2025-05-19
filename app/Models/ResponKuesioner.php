<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResponKuesioner extends Model
{
    use HasFactory;

    protected $table = 'respon_kuesioner';

    protected $fillable = [
        'event_kuesioner_id',
        'jawaban', // Menyimpan jawaban dalam format JSON
    ];

    /**
     * Relasi ke model User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi ke model EventKuesioner
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function eventKuesioner()
    {
        return $this->belongsTo(EventKuesioner::class, 'event_kuesioner_id');
    }
}

