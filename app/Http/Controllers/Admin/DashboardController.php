<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\ClusterBuku;
use App\Models\Gaji;
use App\Models\Shift;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $menu = 'dashboard';
        $totalKaryawan = User::where('role', 'karyawan')->count();
        $totalShift = Shift::count();
        $shiftKosong = Shift::where('status', 'kosong')->count();
        $totalGajiBulanIni = Gaji::where('bulan', date('m'))->sum('total_gaji');
        $gajiSayaBulanIni = Gaji::where('bulan', date('m'))->where('user_id', auth()->user()->id)->first();

        return view('pages.admin.dashboard.index', compact('menu', 'totalKaryawan', 'totalShift', 'shiftKosong', 'totalGajiBulanIni', 'gajiSayaBulanIni'));
    }
}
