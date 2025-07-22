<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kinerja;
use App\Models\User;
use Illuminate\Http\Request;

class KinerjaController extends Controller
{
    public function index()
    {
        $menu = 'kinerja';
        $kinerja = Kinerja::with('user')->get();
        return view('pages.admin.kinerja.index', compact('menu', 'kinerja'));
    }

    public function create()
    {
        $menu = 'kinerja';
        $users = User::where('role', 'karyawan')->get();
        return view('pages.admin.kinerja.create', compact('menu', 'users'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        Kinerja::create($data);
        return redirect()->route('admin.kinerja.index')->with('success', 'Kinerja berhasil ditambahkan');
    }

    public function show(Kinerja $kinerja)
    {
        $menu = 'kinerja';
        return view('pages.admin.kinerja.show', compact('kinerja', 'menu'));
    }

    public function edit(Kinerja $kinerja)
    {
        $menu = 'kinerja';
        $users = User::where('role', 'karyawan')->get();
        return view('pages.admin.kinerja.edit', compact('kinerja', 'menu', 'users'));
    }

    public function update(Request $request, Kinerja $kinerja)
    {
        $kinerja->update($request->all());
        return redirect()->route('admin.kinerja.index')->with('success', 'Kinerja berhasil diubah');
    }

    public function destroy(Kinerja $kinerja)
    {
        $kinerja->delete();
        return redirect()->route('admin.kinerja.index')->with('success', 'Kinerja berhasil dihapus');
    }
}
