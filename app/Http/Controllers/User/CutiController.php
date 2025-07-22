<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cuti;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CutiController extends Controller
{
    public function index()
    {
        $menu = 'cuti';
        $user = Auth::user();
        
        $cutiList = Cuti::where('user_id', $user->id)
            ->orderBy('tanggal_mulai', 'desc')
            ->get();
        
        // Statistik cuti
        $totalCuti = $cutiList->count();
        $cutiDiajukan = $cutiList->where('status', 'diajukan')->count();
        $cutiDisetujui = $cutiList->where('status', 'disetujui')->count();
        $cutiDitolak = $cutiList->where('status', 'ditolak')->count();
        
        return view('pages.user.cuti', compact('menu', 'cutiList', 'totalCuti', 'cutiDiajukan', 'cutiDisetujui', 'cutiDitolak'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'alasan' => 'required|string',
        ]);

        // Hitung durasi cuti
        $tanggalMulai = Carbon::parse($request->tanggal_mulai);
        $tanggalSelesai = Carbon::parse($request->tanggal_selesai);
        $durasi = $tanggalMulai->diffInDays($tanggalSelesai) + 1;

        Cuti::create([
            'user_id' => $user->id,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'durasi' => $durasi,
            'alasan' => $request->alasan,
            'status' => 'diajukan',
        ]);

        return redirect()->route('user.cuti')->with('success', 'Pengajuan cuti berhasil! Menunggu persetujuan admin.');
    }
}
