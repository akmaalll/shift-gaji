<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gaji extends Model
{
    use HasFactory;

    protected $table = 'gaji';

    protected $fillable = [
        'user_id',
        'bulan',
        'total_shift',
        'total_jam_lembur',
        'total_gaji',
        'detail_perhitungan'
    ];

    protected $casts = [
        'detail_perhitungan' => 'array',
        'total_shift' => 'integer',
        'total_jam_lembur' => 'integer',
        'total_gaji' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Method untuk menghitung total gaji berdasarkan shift
    public function hitungTotalGaji()
    {
        $rule = \App\Models\RuleGaji::where('aktif', true)->first();
        if (!$rule) return 0;

        $gajiShift = $this->total_shift * $rule->gaji_per_shift;
        $gajiLembur = $this->total_jam_lembur * $rule->rate_lembur_per_jam;

        $this->total_gaji = $gajiShift + $gajiLembur;
        return $this->total_gaji;
    }
}
