@extends('layouts.app', ['title' => $menu])

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Detail Karyawan</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('admin.karyawan.index') }}">Karyawan</a></div>
                    <div class="breadcrumb-item">Detail</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Informasi Karyawan</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td width="150"><strong>Nama Lengkap</strong></td>
                                                <td>: {{ $karyawan->nama_lengkap }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Username</strong></td>
                                                <td>: {{ $karyawan->username }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Email</strong></td>
                                                <td>: {{ $karyawan->email }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Jabatan</strong></td>
                                                <td>: {{ $karyawan->jabatan ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Role</strong></td>
                                                <td>: {{ ucfirst($karyawan->role) }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Tanggal Registrasi</strong></td>
                                                <td>: {{ $karyawan->created_at->format('d/m/Y H:i') }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <h6>Statistik Karyawan:</h6>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="card bg-primary text-white">
                                                    <div class="card-body">
                                                        <h5>{{ $karyawan->shifts->count() }}</h5>
                                                        <p>Total Shift</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="card bg-success text-white">
                                                    <div class="card-body">
                                                        <h5>{{ $karyawan->cuti->count() }}</h5>
                                                        <p>Total Cuti</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <a href="{{ route('admin.karyawan.index') }}" class="btn btn-secondary">Kembali</a>
                                <a href="{{ route('admin.karyawan.edit', $karyawan->id) }}"
                                    class="btn btn-primary">Edit</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
