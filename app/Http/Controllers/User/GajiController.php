<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gaji;
use App\Models\Shift;
use Illuminate\Support\Facades\Auth;

class GajiController extends Controller
{
    public function index()
    {
        $menu = 'gaji';
        $user = Auth::user();

        $gajiList = Gaji::where('user_id', $user->id)
            ->orderBy('bulan', 'desc')
            ->get();

        // Statistik gaji
        $totalGaji = $gajiList->sum('total_gaji');
        $gajiBulanIni = $gajiList->where('bulan', now()->format('Y-m'))->sum('total_gaji');
        $totalShift = $gajiList->sum('total_shift');
        // dd($totalShift);

        return view('pages.user.gaji', compact('menu', 'gajiList', 'totalGaji', 'gajiBulanIni', 'totalShift'));
    }

    public function detail($gajiId)
    {
        // dd($gaji->gaji_per_shift);
        $menu = 'gaji';
        $user = Auth::user();

        $gaji = Gaji::where('id', $gajiId)
                ->where('user_id', $user->id)
                ->firstOrFail();

        return view('pages.user.gaji-detail', compact('menu', 'gaji'));
    }
}
