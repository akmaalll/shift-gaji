<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gaji;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\GajiRuleEngineService;

class GajiController extends Controller
{
    public function index()
    {
        $menu = 'gaji';
        $gaji = Gaji::with('user')->get();
        return view('pages.admin.gaji.index', compact('menu', 'gaji'));
    }

    public function create()
    {
        $menu = 'gaji';
        $users = User::where('role', 'karyawan')->get();
        return view('pages.admin.gaji.create', compact('menu', 'users'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        Gaji::create($data);
        return redirect()->route('admin.gaji.index')->with('success', 'Gaji berhasil ditambahkan');
    }

    public function show(Gaji $gaji)
    {
        $menu = 'gaji';
        return view('pages.admin.gaji.show', compact('gaji', 'menu'));
    }

    public function edit(Gaji $gaji)
    {
        $menu = 'gaji';
        $users = User::where('role', 'karyawan')->get();
        return view('pages.admin.gaji.edit', compact('gaji', 'menu', 'users'));
    }

    public function update(Request $request, Gaji $gaji)
    {
        $gaji->update($request->all());
        return redirect()->route('admin.gaji.index')->with('success', 'Gaji berhasil diubah');
    }

    public function destroy(Gaji $gaji)
    {
        $gaji->delete();
        return redirect()->route('admin.gaji.index')->with('success', 'Gaji berhasil dihapus');
    }

    public function prosesGajiOtomatis(GajiRuleEngineService $service)
    {
        $service->prosesGajiBulan();
        return redirect()->back()->with('success', 'Proses gaji otomatis selesai!');
    }
}
