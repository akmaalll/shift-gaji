<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Presensi;
use App\Models\User;
use App\Models\Shift;
use Illuminate\Http\Request;

class PresensiController extends Controller
{
    public function index()
    {
        $menu = 'presensi';
        $presensi = Presensi::with(['user', 'shift'])->orderBy('tanggal_presensi', 'desc')->paginate(15);
        return view('pages.admin.presensi.index', compact('menu', 'presensi'));
    }

    public function create()
    {
        $menu = 'presensi';
        $karyawan = User::where('role', 'karyawan')->get();
        $shifts = Shift::where('status', 'diambil')->get();
        return view('pages.admin.presensi.create', compact('menu', 'karyawan', 'shifts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'shift_id' => 'required|exists:shifts,id',
            'tanggal_presensi' => 'required|date',
            'jam_masuk' => 'nullable|date_format:H:i',
            'jam_keluar' => 'nullable|date_format:H:i',
            'status' => 'required|in:hadir,izin,sakit,alpha',
            'keterangan' => 'nullable|string'
        ]);

        // Check if attendance record already exists
        $existingPresensi = Presensi::where([
            'user_id' => $request->user_id,
            'shift_id' => $request->shift_id,
            'tanggal_presensi' => $request->tanggal_presensi
        ])->first();

        if ($existingPresensi) {
            return redirect()->back()->with('error', 'Data presensi untuk karyawan dan shift ini pada tanggal tersebut sudah ada');
        }

        Presensi::create($request->all());
        return redirect()->route('admin.presensi.index')->with('success', 'Data presensi berhasil ditambahkan');
    }

    public function show(Presensi $presensi)
    {
        $menu = 'presensi';
        return view('pages.admin.presensi.show', compact('presensi', 'menu'));
    }

    public function edit(Presensi $presensi)
    {
        $menu = 'presensi';
        $karyawan = User::where('role', 'karyawan')->get();
        $shifts = Shift::where('status', 'diambil')->get();
        return view('pages.admin.presensi.edit', compact('presensi', 'menu', 'karyawan', 'shifts'));
    }

    public function update(Request $request, Presensi $presensi)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'shift_id' => 'required|exists:shifts,id',
            'tanggal_presensi' => 'required|date',
            'jam_masuk' => 'nullable|date_format:H:i',
            'jam_keluar' => 'nullable|date_format:H:i',
            'status' => 'required|in:hadir,izin,sakit,alpha',
            'keterangan' => 'nullable|string'
        ]);

        // Check if attendance record already exists (excluding current record)
        $existingPresensi = Presensi::where([
            'user_id' => $request->user_id,
            'shift_id' => $request->shift_id,
            'tanggal_presensi' => $request->tanggal_presensi
        ])->where('id', '!=', $presensi->id)->first();

        if ($existingPresensi) {
            return redirect()->back()->with('error', 'Data presensi untuk karyawan dan shift ini pada tanggal tersebut sudah ada');
        }

        $presensi->update($request->all());
        return redirect()->route('admin.presensi.index')->with('success', 'Data presensi berhasil diperbarui');
    }

    public function destroy(Presensi $presensi)
    {
        $presensi->delete();
        return redirect()->route('admin.presensi.index')->with('success', 'Data presensi berhasil dihapus');
    }

    public function rekap()
    {
        $menu = 'presensi';
        $bulan = request('bulan', date('Y-m'));
        $karyawan = request('karyawan_id');

        $query = Presensi::with(['user', 'shift'])
            ->whereYear('tanggal_presensi', date('Y', strtotime($bulan . '-01')))
            ->whereMonth('tanggal_presensi', date('m', strtotime($bulan . '-01')));

        if ($karyawan) {
            $query->where('user_id', $karyawan);
        }

        $presensi = $query->orderBy('tanggal_presensi', 'desc')->get();
        $karyawanList = User::where('role', 'karyawan')->get();

        return view('pages.admin.presensi.rekap', compact('menu', 'presensi', 'karyawanList', 'bulan', 'karyawan'));
    }
}
