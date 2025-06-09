<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResponKuesioner extends Model
{
    protected $fillable = [
        'kuesioner_id', 'user_id', 'jawaban'
    ];

    public function kuesioner()
    {
        return $this->belongsTo(Kuesioner::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 