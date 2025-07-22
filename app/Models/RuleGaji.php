<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RuleGaji extends Model
{
    protected $table = 'rule_gaji';
    protected $fillable = [
        'nama_rule',
        'deskripsi',
        'gaji_per_shift',
        'jam_kerja_per_shift',
        'rate_lembur_per_jam',
        'aktif'
    ];

    protected $casts = [
        'aktif' => 'boolean',
        'gaji_per_shift' => 'decimal:2',
        'jam_kerja_per_shift' => 'integer',
        'rate_lembur_per_jam' => 'decimal:2',
    ];
}
