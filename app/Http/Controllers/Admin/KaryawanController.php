<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class KaryawanController extends Controller
{
    public function index()
    {
        $menu = 'karyawan';
        $karyawan = User::where('role', 'karyawan')->get();
        return view('pages.admin.karyawan.index', compact('menu', 'karyawan'));
    }

    public function create()
    {
        $menu = 'karyawan';
        return view('pages.admin.karyawan.create', compact('menu'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'nama_lengkap' => 'required|string|max:100',
            'jabatan' => 'required|string|max:100',
        ]);

        User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'nama_lengkap' => $request->nama_lengkap,
            'jabatan' => $request->jabatan,
            'role' => 'karyawan'
        ]);

        return redirect()->route('admin.karyawan.index')->with('success', 'Karyawan berhasil ditambahkan');
    }

    public function show(User $karyawan)
    {
        $menu = 'karyawan';
        return view('pages.admin.karyawan.show', compact('karyawan', 'menu'));
    }

    public function edit(User $karyawan)
    {
        $menu = 'karyawan';
        return view('pages.admin.karyawan.edit', compact('karyawan', 'menu'));
    }

    public function update(Request $request, User $karyawan)
    {
        $request->validate([
            'username' => 'required|unique:users,username,' . $karyawan->id,
            'email' => 'required|email|unique:users,email,' . $karyawan->id,
            'nama_lengkap' => 'required|string|max:100',
            'jabatan' => 'required|string|max:100',
        ]);

        $data = [
            'username' => $request->username,
            'email' => $request->email,
            'nama_lengkap' => $request->nama_lengkap,
            'jabatan' => $request->jabatan,
        ];

        if ($request->filled('password')) {
            $request->validate(['password' => 'min:6']);
            $data['password'] = Hash::make($request->password);
        }

        $karyawan->update($data);
        return redirect()->route('admin.karyawan.index')->with('success', 'Data karyawan berhasil diperbarui');
    }

    public function destroy(User $karyawan)
    {
        $karyawan->delete();
        return redirect()->route('admin.karyawan.index')->with('success', 'Karyawan berhasil dihapus');
    }
}
