@extends('layouts.app', ['title' => $menu])

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Karyawan</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('admin.karyawan.index') }}">Karyawan</a></div>
                    <div class="breadcrumb-item">Edit</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Form Edit Karyawan</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.karyawan.update', $karyawan->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Username <span class="text-danger">*</span></label>
                                                <input type="text" name="username"
                                                    class="form-control @error('username') is-invalid @enderror"
                                                    value="{{ old('username', $karyawan->username) }}" required>
                                                @error('username')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Email <span class="text-danger">*</span></label>
                                                <input type="email" name="email"
                                                    class="form-control @error('email') is-invalid @enderror"
                                                    value="{{ old('email', $karyawan->email) }}" required>
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Password <small>(Kosongkan jika tidak ingin mengubah)</small></label>
                                                <input type="password" name="password"
                                                    class="form-control @error('password') is-invalid @enderror">
                                                @error('password')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nama Lengkap <span class="text-danger">*</span></label>
                                                <input type="text" name="nama_lengkap"
                                                    class="form-control @error('nama_lengkap') is-invalid @enderror"
                                                    value="{{ old('nama_lengkap', $karyawan->nama_lengkap) }}" required>
                                                @error('nama_lengkap')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Jabatan <span class="text-danger">*</span></label>
                                                <input type="text" name="jabatan"
                                                    class="form-control @error('jabatan') is-invalid @enderror"
                                                    value="{{ old('jabatan', $karyawan->jabatan) }}" required>
                                                @error('jabatan')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                        <a href="{{ route('admin.karyawan.index') }}" class="btn btn-secondary">Kembali</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
