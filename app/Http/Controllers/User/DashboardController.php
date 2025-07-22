<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shift;
use App\Models\Cuti;
use App\Models\Gaji;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $menu = 'dashboard';
        $user = Auth::user();

        // Statistik shift
        $totalShiftKosong = Shift::kosong()
            ->where('tanggal_shift', '>=', now()->format('Y-m-d'))
            ->count();

        $totalShiftDiambil = Shift::where('user_id', $user->id)
            ->where('status', 'diambil')
            ->count();

        $totalShiftSelesai = Shift::where('user_id', $user->id)
            ->where('status', 'selesai')
            ->count();

        // Shift terbaru
        $recentShifts = Shift::where('user_id', $user->id)
            ->whereIn('status', ['diambil', 'selesai'])
            ->orderBy('tanggal_shift', 'desc')
            ->limit(5)
            ->get();

        // Statistik gaji
        $totalGaji = Gaji::where('user_id', $user->id)->sum('total_gaji');
        $gajiBulanIni = Gaji::where('user_id', $user->id)
            ->where('bulan', now()->format('Y-m'))
            ->sum('total_gaji');

        return view('pages.user.dashboard', compact(
            'menu',
            'totalShiftKosong',
            'totalShiftDiambil',
            'totalShiftSelesai',
            'recentShifts',
            'totalGaji',
            'gajiBulanIni'
        ));
    }
}
