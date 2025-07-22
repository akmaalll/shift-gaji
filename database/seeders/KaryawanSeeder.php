<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class KaryawanSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'username' => 'admin',
            'nama_lengkap' => 'Administrator',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'jabatan' => 'Administrator'
        ]);

        // Karyawan - Aiska
        User::create([
            'username' => 'aiska',
            'nama_lengkap' => 'Aiska',
            'email' => 'aiska@example.com',
            'password' => Hash::make('password'),
            'role' => 'karyawan',
            'jabatan' => ''
        ]);

        // Karyawan - Winda
        User::create([
            'username' => 'winda',
            'nama_lengkap' => 'Winda',
            'email' => 'winda@example.com',
            'password' => Hash::make('password'),
            'role' => 'karyawan',
            'jabatan' => ''
        ]);

        // Karyawan - Clara
        User::create([
            'username' => 'clara',
            'nama_lengkap' => 'Clara',
            'email' => 'clara@example.com',
            'password' => Hash::make('password'),
            'role' => 'karyawan',
            'jabatan' => ''
        ]);

        // Karyawan - Indah
        User::create([
            'username' => 'indah',
            'nama_lengkap' => 'Indah',
            'email' => 'indah@example.com',
            'password' => Hash::make('password'),
            'role' => 'karyawan',
            'jabatan' => ''
        ]);

        // Karyawan - Ainun
        User::create([
            'username' => 'ainun',
            'nama_lengkap' => 'Ainun',
            'email' => 'ainun@example.com',
            'password' => Hash::make('password'),
            'role' => 'karyawan',
            'jabatan' => ''
        ]);

        // Karyawan - Fania
        User::create([
            'username' => 'fania',
            'nama_lengkap' => 'Fania',
            'email' => 'fania@example.com',
            'password' => Hash::make('password'),
            'role' => 'karyawan',
            'jabatan' => ''
        ]);
    }
}
