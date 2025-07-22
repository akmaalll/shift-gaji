<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    protected $fillable = [
        'user_id',
        'tanggal_shift',
        'jenis_shift',
        'jam_mulai',
        'jam_selesai',
        'status',
        'keterangan'
    ];

    protected $casts = [
        'tanggal_shift' => 'date',
        'jam_mulai' => 'datetime',
        'jam_selesai' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function presensi()
    {
        return $this->hasMany(Presensi::class);
    }

    // Method untuk mengambil shift
    public function ambilShift($userId)
    {
        if ($this->status === 'kosong' && $this->user_id === null) {
            $this->update([
                'user_id' => $userId,
                'status' => 'diambil',
                'keterangan' => 'Shift telah diambil oleh karyawan'
            ]);
            return true;
        }
        return false;
    }

    // Scope untuk shift yang kosong
    public function scopeKosong($query)
    {
        return $query->where('status', 'kosong')->whereNull('user_id');
    }

    // Scope untuk shift yang sudah diambil
    public function scopeDiambil($query)
    {
        return $query->where('status', 'diambil')->whereNotNull('user_id');
    }

    // Scope untuk shift yang sudah selesai
    public function scopeSelesai($query)
    {
        return $query->where('status', 'selesai');
    }
}
