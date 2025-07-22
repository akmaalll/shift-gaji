@extends('layouts.app', ['title' => 'Edit Rule Shift'])
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Rule Shift</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item">Rule Shift</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Edit Rule Shift</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('ruleshift.update', $data->id) }}" method="POST">
                                    @csrf
                                    @method('put')
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama
                                            Rule</label>
                                        <div class="col-sm-12 col-md-7">
                                            <input type="text" class="form-control" name="nama_rule"
                                                value="{{ $data->nama_rule }}" required>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label
                                            class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Deskripsi</label>
                                        <div class="col-sm-12 col-md-7">
                                            <textarea class="form-control" name="deskripsi">{{ $data->deskripsi }}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Max
                                            Shift/Bulan</label>
                                        <div class="col-sm-12 col-md-7">
                                            <input type="number" class="form-control" name="max_shift_per_bulan"
                                                value="{{ $data->max_shift_per_bulan }}" required>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Min Jeda
                                            Hari</label>
                                        <div class="col-sm-12 col-md-7">
                                            <input type="number" class="form-control" name="min_jeda_hari"
                                                value="{{ $data->min_jeda_hari }}" required>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label
                                            class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Fairness</label>
                                        <div class="col-sm-12 col-md-7">
                                            <select class="form-control" name="fairness">
                                                <option value="1" @if ($data->fairness) selected @endif>Ya
                                                </option>
                                                <option value="0" @if (!$data->fairness) selected @endif>
                                                    Tidak</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Aktif</label>
                                        <div class="col-sm-12 col-md-7">
                                            <select class="form-control" name="aktif">
                                                <option value="1" @if ($data->aktif) selected @endif>Ya
                                                </option>
                                                <option value="0" @if (!$data->aktif) selected @endif>
                                                    Tidak</option>
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
@endsection
