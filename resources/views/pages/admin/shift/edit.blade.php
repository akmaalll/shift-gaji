@extends('layouts.app', ['title' => $menu])
@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    @endpush
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Shift</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item">Shift</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Edit Shift</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.shift.update', $shift->id) }}" method="POST">
                                    @csrf
                                    @method('put')
                                    <div class="form-group row mb-4">
                                        <label
                                            class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Karyawan</label>
                                        <div class="col-sm-12 col-md-7">
                                            <select class="form-control selectric" name="user_id">
                                                <option value="">Pilih Karyawan</option>
                                                @foreach ($users as $u)
                                                    <option value="{{ $u->id }}"
                                                        @if ($shift->user_id == $u->id) selected @endif>
                                                        {{ $u->nama_lengkap }} ({{ $u->jabatan }})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Tanggal
                                            Shift</label>
                                        <div class="col-sm-12 col-md-7">
                                            <input type="date" class="form-control" name="tanggal_shift"
                                                value="{{ $shift->tanggal_shift->format('Y-m-d') }}" required>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Jenis
                                            Shift</label>
                                        <div class="col-sm-12 col-md-7">
                                            <select class="form-control selectric" name="jenis_shift" required>
                                                <option value="">Pilih Jenis Shift</option>
                                                <option value="pagi" @if ($shift->jenis_shift == 'pagi') selected @endif>
                                                    Pagi</option>
                                                <option value="malam" @if ($shift->jenis_shift == 'malam') selected @endif>
                                                    Malam</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Jam
                                            Mulai</label>
                                        <div class="col-sm-12 col-md-7">
                                            <input type="time" class="form-control" name="jam_mulai"
                                                value="{{ $shift->jam_mulai ? $shift->jam_mulai->format('H:i') : '' }}"
                                                required>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Jam
                                            Selesai</label>
                                        <div class="col-sm-12 col-md-7">
                                            <input type="time" class="form-control" name="jam_selesai"
                                                value="{{ $shift->jam_selesai ? $shift->jam_selesai->format('H:i') : '' }}"
                                                required>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Status</label>
                                        <div class="col-sm-12 col-md-7">
                                            <select class="form-control selectric" name="status">
                                                <option value="kosong" @if ($shift->status == 'kosong') selected @endif>
                                                    Kosong</option>
                                                <option value="diambil" @if ($shift->status == 'diambil') selected @endif>
                                                    Diambil</option>
                                                <option value="selesai" @if ($shift->status == 'selesai') selected @endif>
                                                    Selesai</option>
                                                <option value="dibatalkan"
                                                    @if ($shift->status == 'dibatalkan') selected @endif>Dibatalkan</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                                        <div class="col-sm-12 col-md-7">
                                            <button class="btn btn-primary">Update</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    @push('scripts')
        <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
    @endpush
@endsection
