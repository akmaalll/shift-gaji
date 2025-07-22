<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Shift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShiftController extends Controller
{
    public function index()
    {
        $menu = 'shift';
        $user = Auth::user();

        // Shift yang tersedia (kosong)
        $shiftsKosong = Shift::kosong()
            ->where('tanggal_shift', '>=', now()->format('Y-m-d'))
            ->orderBy('tanggal_shift')
            ->orderBy('jam_mulai')
            ->get();

        // Shift yang sudah diambil oleh user ini
        $shiftsDiambil = Shift::where('user_id', $user->id)
            ->whereIn('status', ['diambil', 'selesai'])
            ->orderBy('tanggal_shift', 'desc')
            ->orderBy('jam_mulai')
            ->get();

        // Statistik shift
        $totalShiftKosong = $shiftsKosong->count();
        $totalShiftDiambil = $shiftsDiambil->where('status', 'diambil')->count();
        $totalShiftSelesai = $shiftsDiambil->where('status', 'selesai')->count();

        return view('pages.user.shift', compact(
            'menu',
            'shiftsKosong',
            'shiftsDiambil',
            'totalShiftKosong',
            'totalShiftDiambil',
            'totalShiftSelesai'
        ));
    }

    // Method untuk mengambil shift
    public function ambilShift($id)
    {
        $shift = Shift::findOrFail($id);
        $user = Auth::user();

        // Cek apakah shift masih kosong
        if ($shift->status !== 'kosong' || $shift->user_id !== null) {
            return redirect()->back()->with('error', 'Shift sudah tidak tersedia');
        }

        // Ambil shift
        if ($shift->ambilShift($user->id)) {
            return redirect()->back()->with('success', 'Shift berhasil diambil');
        }

        return redirect()->back()->with('error', 'Gagal mengambil shift');
    }

   
}
