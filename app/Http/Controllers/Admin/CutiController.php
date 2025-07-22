<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cuti;
use App\Models\User;
use Illuminate\Http\Request;

class CutiController extends Controller
{
    public function index()
    {
        $menu = 'cuti';
        $cuti = Cuti::with('user')->get();
        return view('pages.admin.cuti.index', compact('menu', 'cuti'));
    }

    public function create()
    {
        $menu = 'cuti';
        $users = User::where('role', 'karyawan')->get();
        return view('pages.admin.cuti.create', compact('menu', 'users'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        Cuti::create($data);
        return redirect()->route('admin.cuti.index')->with('success', 'Cuti berhasil ditambahkan');
    }

    public function show(Cuti $cuti)
    {
        $menu = 'cuti';
        return view('pages.admin.cuti.show', compact('cuti', 'menu'));
    }

    public function edit(Cuti $cuti)
    {
        $menu = 'cuti';
        $users = User::where('role', 'karyawan')->get();
        return view('pages.admin.cuti.edit', compact('cuti', 'menu', 'users'));
    }

    public function update(Request $request, Cuti $cuti)
    {
        $cuti->update($request->all());
        return redirect()->route('admin.cuti.index')->with('success', 'Cuti berhasil diubah');
    }

    public function destroy(Cuti $cuti)
    {
        $cuti->delete();
        return redirect()->route('admin.cuti.index')->with('success', 'Cuti berhasil dihapus');
    }
}
