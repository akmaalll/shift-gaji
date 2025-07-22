@extends('layouts.app', ['title' => $menu])
@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    @endpush
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Tambah Shift</h1>
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
                                <h4>Tambah Shift</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.shift.store') }}" method="POST">
                                    @csrf
                                    <div class="form-group row mb-4">
                                        <label
                                            class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Karyawan</label>
                                        <div class="col-sm-12 col-md-7">
                                            <select class="form-control selectric" name="user_id">
                                                <option value="">Pilih Karyawan</option>
                                                @foreach ($users as $u)
                                                    <option value="{{ $u->id }}">{{ $u->nama_lengkap }}
                                                        ({{ $u->jabatan }})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Tanggal
                                            Shift</label>
                                        <div class="col-sm-12 col-md-7">
                                            <input type="date" class="form-control" name="tanggal_shift" required>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Jenis
                                            Shift</label>
                                        <div class="col-sm-12 col-md-7">
                                            <select class="form-control selectric" name="jenis_shift" required>
                                                <option value="">Pilih Jenis Shift</option>
                                                <option value="pagi">Pagi</option>
                                                <option value="siang">Siang</option>
                                                <option value="malam">Malam</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Jam
                                            Mulai</label>
                                        <div class="col-sm-12 col-md-7">
                                            <input type="time" class="form-control" name="jam_mulai" required>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Jam
                                            Selesai</label>
                                        <div class="col-sm-12 col-md-7">
                                            <input type="time" class="form-control" name="jam_selesai" required>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Status</label>
                                        <div class="col-sm-12 col-md-7">
                                            <select class="form-control selectric" name="status">
                                                <option value="kosong">Kosong</option>
                                                <option value="diambil">Diambil</option>
                                                <option value="selesai">Selesai</option>
                                                <option value="dibatalkan">Dibatalkan</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                                        <div class="col-sm-12 col-md-7">
                                            <button class="btn btn-primary">Simpan</button>
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
