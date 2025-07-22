@extends('layouts.app')

@section('title', 'Edit Presensi')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Presensi</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('admin.presensi.index') }}">Presensi</a></div>
                    <div class="breadcrumb-item">Edit</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Form Edit Presensi</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.presensi.update', $presensi->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Karyawan <span class="text-danger">*</span></label>
                                                <select name="user_id"
                                                    class="form-control @error('user_id') is-invalid @enderror" required>
                                                    <option value="">Pilih Karyawan</option>
                                                    @foreach ($karyawan as $k)
                                                        <option value="{{ $k->id }}"
                                                            {{ old('user_id', $presensi->user_id) == $k->id ? 'selected' : '' }}>
                                                            {{ $k->nama_lengkap }} ({{ $k->jabatan }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('user_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Shift <span class="text-danger">*</span></label>
                                                <select name="shift_id"
                                                    class="form-control @error('shift_id') is-invalid @enderror" required>
                                                    <option value="">Pilih Shift</option>
                                                    @foreach ($shifts as $s)
                                                        <option value="{{ $s->id }}"
                                                            {{ old('shift_id', $presensi->shift_id) == $s->id ? 'selected' : '' }}>
                                                            {{ ucfirst($s->jenis_shift) }} -
                                                            {{ $s->jam_mulai ? $s->jam_mulai->format('H:i') : '-' }} -
                                                            {{ $s->jam_selesai ? $s->jam_selesai->format('H:i') : '-' }}
                                                            ({{ $s->user->nama_lengkap ?? 'Kosong' }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('shift_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Tanggal Presensi <span class="text-danger">*</span></label>
                                                <input type="date" name="tanggal_presensi"
                                                    class="form-control @error('tanggal_presensi') is-invalid @enderror"
                                                    value="{{ old('tanggal_presensi', $presensi->tanggal_presensi) }}"
                                                    required>
                                                @error('tanggal_presensi')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Status <span class="text-danger">*</span></label>
                                                <select name="status"
                                                    class="form-control @error('status') is-invalid @enderror" required>
                                                    <option value="">Pilih Status</option>
                                                    <option value="hadir"
                                                        {{ old('status', $presensi->status) == 'hadir' ? 'selected' : '' }}>
                                                        Hadir</option>
                                                    <option value="izin"
                                                        {{ old('status', $presensi->status) == 'izin' ? 'selected' : '' }}>
                                                        Izin</option>
                                                    <option value="sakit"
                                                        {{ old('status', $presensi->status) == 'sakit' ? 'selected' : '' }}>
                                                        Sakit</option>
                                                    <option value="alpha"
                                                        {{ old('status', $presensi->status) == 'alpha' ? 'selected' : '' }}>
                                                        Alpha</option>
                                                </select>
                                                @error('status')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Jam Masuk</label>
                                                <input type="time" name="jam_masuk"
                                                    class="form-control @error('jam_masuk') is-invalid @enderror"
                                                    value="{{ old('jam_masuk', $presensi->jam_masuk ? $presensi->jam_masuk->format('H:i') : '') }}">
                                                @error('jam_masuk')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Jam Keluar</label>
                                                <input type="time" name="jam_keluar"
                                                    class="form-control @error('jam_keluar') is-invalid @enderror"
                                                    value="{{ old('jam_keluar', $presensi->jam_keluar ? $presensi->jam_keluar->format('H:i') : '') }}">
                                                @error('jam_keluar')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Keterangan</label>
                                        <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" rows="3">{{ old('keterangan', $presensi->keterangan) }}</textarea>
                                        @error('keterangan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                        <a href="{{ route('admin.presensi.index') }}" class="btn btn-secondary">Kembali</a>
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
