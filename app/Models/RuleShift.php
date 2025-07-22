<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RuleShift extends Model
{
    protected $table = 'rule_shift';
    protected $fillable = [
        'nama_rule',
        'deskripsi',
        'max_shift_per_minggu',
        'min_jeda_hari',
        'fairness',
        'aktif'
    ];
    protected $casts = [
        'fairness' => 'boolean',
        'aktif' => 'boolean',
    ];
}
