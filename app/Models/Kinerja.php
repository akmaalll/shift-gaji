<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kinerja extends Model
{
    protected $table = 'kinerja';
    protected $fillable = [
        'user_id',
        'tanggal',
        'deskripsi',
        'nilai'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
