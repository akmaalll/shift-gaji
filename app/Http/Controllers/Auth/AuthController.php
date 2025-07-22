<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index()
    {
        return view('pages.auth.login');
    }

    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Coba login dengan data yang dimasukkan
        if (Auth::attempt($request->only('email', 'password'))) {
            // Redirect berdasarkan role
            $user = Auth::user();
            if ($user->role === 'admin') {
                // dd($user->role);
                return redirect()->route('admin.dashboard');
            } elseif ($user->role === 'karyawan') {
                return redirect()->route('user.dashboard');
            }
        }

        // Jika gagal login
        return back()->withErrors(['email' => 'Email atau password salah.']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login')->with('success', 'Anda berhasil logout.');
    }

    public function register()
    {
        return view('pages.auth.register');
    }

    public function store(Request $request)
    {
        // dd($request->all()); 
        // Buat user baru
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'nama_lengkap' => $request->nama_lengkap,
            'role' => 'user',
            'password' => Hash::make($request->password),
        ]);

        // Login user setelah registrasi
        Auth::login($user);

        // Redirect ke form preferensi
        return redirect()->route('preferensi.form')->with('success', 'Anda berhasil register.');
    }
}
