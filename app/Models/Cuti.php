<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cuti extends Model
{
    protected $table = 'cuti';
    protected $fillable = [
        'user_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'durasi',
        'alasan',
        'status',
        'catatan_admin'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
