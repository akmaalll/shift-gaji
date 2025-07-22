<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CutiRule extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_rule',
        'max_cuti_per_minggu',
        'max_cuti_per_bulan',
        'jatah_libur_per_minggu',
        'keterangan',
        'aktif'
    ];

    protected $casts = [
        'aktif' => 'boolean'
    ];
} 