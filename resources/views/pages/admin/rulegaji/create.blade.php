@extends('layouts.app', ['title' => $menu])
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Tambah Rule Gaji</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('admin.rule-gaji.index') }}">Rule Gaji</a></div>
                    <div class="breadcrumb-item">Tambah</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Tambah Rule Gaji</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.rule-gaji.store') }}" method="POST">
                                    @csrf
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama
                                            Rule</label>
                                        <div class="col-sm-12 col-md-7">
                                            <input type="text" class="form-control" name="nama_rule" required>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label
                                            class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Deskripsi</label>
                                        <div class="col-sm-12 col-md-7">
                                            <textarea class="form-control" name="deskripsi"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Gaji per
                                            Shift</label>
                                        <div class="col-sm-12 col-md-7">
                                            <input type="number" class="form-control" name="gaji_per_shift" value="50000"
                                                required>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Jam Kerja per
                                            Shift</label>
                                        <div class="col-sm-12 col-md-7">
                                            <input type="number" class="form-control" name="jam_kerja_per_shift"
                                                value="8" required>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Rate Lembur per
                                            Jam</label>
                                        <div class="col-sm-12 col-md-7">
                                            <input type="number" class="form-control" name="rate_lembur_per_jam"
                                                value="6250" required>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Aktif</label>
                                        <div class="col-sm-12 col-md-7">
                                            <select class="form-control" name="aktif">
                                                <option value="1">Ya</option>
                                                <option value="0">Tidak</option>
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
@endsection
