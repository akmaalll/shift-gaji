<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shift;
use App\Models\User;
use App\Models\RuleShift;
use App\Services\ShiftRuleEngineService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Artisan;

class ShiftController extends Controller
{
    protected $shiftService;

    public function __construct(ShiftRuleEngineService $shiftService)
    {
        $this->shiftService = $shiftService;
    }

    public function index()
    {
        $menu = 'shift';
        $shifts = Shift::with('user')
            ->orderBy('tanggal_shift', 'desc')
            ->orderBy('jam_mulai')
            ->get();

        // Hitung jumlah shift kosong
        $jumlah_shift_kosong = Shift::where('status', 'kosong')->count();
        $boleh_penjadwalan = $jumlah_shift_kosong >= 7;

        return view('pages.admin.shift.index', compact('shifts', 'menu', 'boleh_penjadwalan', 'jumlah_shift_kosong'));
    }

    public function create()
    {
        $users = User::where('role', 'karyawan')->get();
        $menu = 'shift';
        return view('pages.admin.shift.create', compact('users', 'menu'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_shift' => 'required|date',
            'jenis_shift' => 'required|in:pagi,malam',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'user_id' => 'nullable|exists:users,id',
            'status' => 'required|in:kosong,diambil,selesai',
            'keterangan' => 'nullable|string'
        ]);

        Shift::create($request->all());
        return redirect()->route('admin.shift.index')->with('success', 'Shift berhasil dibuat');
    }

    public function show(Shift $shift)
    {
        $menu = 'shift';
        return view('pages.admin.shift.show', compact('shift', 'menu'));
    }

    public function edit(Shift $shift)
    {
        $menu = 'shift';
        $users = User::where('role', 'karyawan')->get();
        return view('pages.admin.shift.edit', compact('shift', 'users', 'menu'));
    }

    public function update(Request $request, Shift $shift)
    {
        $request->validate([
            'tanggal_shift' => 'required|date',
            'jenis_shift' => 'required|in:pagi,malam',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'user_id' => 'nullable|exists:users,id',
            'status' => 'required|in:kosong,diambil,selesai',
            'keterangan' => 'nullable|string'
        ]);

        $shift->update($request->all());
        return redirect()->route('admin.shift.index')->with('success', 'Shift berhasil diperbarui');
    }

    public function destroy(Shift $shift)
    {
        $shift->delete();
        return redirect()->route('admin.shift.index')->with('success', 'Shift berhasil dihapus');
    }

    /**
     * Penjadwalan shift otomatis berdasarkan rule-based system
     */
    public function penjadwalanOtomatis(Request $request)
    {
        try {
            // Jalankan penjadwalan otomatis untuk minggu berjalan (tanpa parameter tanggal)
            $result = $this->shiftService->penjadwalanOtomatis();

            if ($result['success']) {
                return redirect()->route('admin.shift.index')
                    ->with('success', $result['message']);
            } else {
                return redirect()->route('admin.shift.index')
                    ->with('error', $result['message']);
            }
        } catch (\Exception $e) {
            Log::error('Error dalam penjadwalan otomatis: ' . $e->getMessage());
            return redirect()->route('admin.shift.index')
                ->with('error', 'Terjadi kesalahan dalam penjadwalan otomatis: ' . $e->getMessage());
        }
    }

    /**
     * Validasi jadwal untuk memastikan tidak ada konflik
     */
    public function validasiJadwal(Request $request)
    {
        $request->validate([
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai'
        ]);

        try {
            $result = $this->shiftService->validasiJadwal(
                $request->tanggal_mulai,
                $request->tanggal_selesai
            );

            return view('pages.admin.shift.validasi', [
                'valid' => $result['valid'],
                'conflicts' => $result['conflicts'],
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai
            ]);
        } catch (\Exception $e) {
            Log::error('Error dalam validasi jadwal: ' . $e->getMessage());
            return redirect()->route('admin.shift.index')
                ->with('error', 'Terjadi kesalahan dalam validasi jadwal');
        }
    }

    /**
     * Tampilkan daftar shift kosong
     */
    public function shiftKosong(Request $request)
    {
        $request->validate([
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai'
        ]);

        $shifts = $this->shiftService->getShiftKosong(
            $request->tanggal_mulai,
            $request->tanggal_selesai
        );

        return view('pages.admin.shift.kosong', compact('shifts'));
    }

    /**
     * Dashboard shift dengan statistik
     */
    public function dashboard()
    {
        $totalShifts = Shift::count();
        $shiftsKosong = Shift::where('status', 'kosong')->count();
        $shiftsDiambil = Shift::where('status', 'diambil')->count();
        $shiftsSelesai = Shift::where('status', 'selesai')->count();

        // Statistik per jenis shift
        $shiftsPerJenis = Shift::selectRaw('jenis_shift, COUNT(*) as total')
            ->groupBy('jenis_shift')
            ->get();

        // Statistik per karyawan
        $shiftsPerKaryawan = Shift::with('user')
            ->selectRaw('user_id, COUNT(*) as total')
            ->whereNotNull('user_id')
            ->groupBy('user_id')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        return view('pages.admin.shift.dashboard', compact(
            'totalShifts',
            'shiftsKosong',
            'shiftsDiambil',
            'shiftsSelesai',
            'shiftsPerJenis',
            'shiftsPerKaryawan'
        ));
    }

    /**
     * Assign karyawan ke shift kosong
     */
    public function assignKaryawan(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        $shift = Shift::findOrFail($id);

        if ($shift->status !== 'kosong') {
            return redirect()->back()->with('error', 'Shift sudah tidak tersedia');
        }

        // Cek apakah karyawan eligible
        $user = User::find($request->user_id);
        $rule = RuleShift::where('aktif', true)->first();

        if (!$this->shiftService->checkKaryawanEligible($user, $shift, $rule)) {
            return redirect()->back()->with('error', 'Karyawan tidak eligible untuk shift ini');
        }

        $shift->user_id = $request->user_id;
        $shift->status = 'diambil';
        $shift->save();

        return redirect()->back()->with('success', 'Karyawan berhasil ditugaskan ke shift');
    }
}
