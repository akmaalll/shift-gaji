<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    protected $table = 'presensi';
    protected $fillable = [
        'user_id',
        'shift_id',
        'tanggal_presensi',
        'jam_masuk',
        'jam_keluar',
        'status',
        'keterangan'
    ];

    protected $casts = [
        'tanggal_presensi' => 'date',
        'jam_masuk' => 'datetime',
        'jam_keluar' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }
}
