<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShiftSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_shift',
        'jam_mulai',
        'jam_selesai',
        'keterangan',
        'aktif'
    ];

    protected $casts = [
        'jam_mulai' => 'datetime',
        'jam_selesai' => 'datetime',
        'aktif' => 'boolean'
    ];

    public function shifts()
    {
        return $this->hasMany(Shift::class, 'jenis_shift', 'nama_shift');
    }
}
