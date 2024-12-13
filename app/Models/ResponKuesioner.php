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
        'user_id',
        'jawaban', // Menyimpan jawaban dalam format JSON
    ];

    // In ResponKuesioner model
    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }
}

