@extends('layouts.app', ['title' => 'Tambah Gaji'])
@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    @endpush
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Tambah Gaji</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item">Gaji</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Tambah Gaji</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('gaji.store') }}" method="POST">
                                    @csrf
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">User</label>
                                        <div class="col-sm-12 col-md-7">
                                            <select class="form-control selectric" name="user_id">
                                                <option value="">Pilih User</option>
                                                @foreach ($users as $u)
                                                    <option value="{{ $u->id }}">{{ $u->nama_lengkap }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Bulan</label>
                                        <div class="col-sm-12 col-md-7">
                                            <input type="month" class="form-control" name="bulan" required>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Total Jam
                                            Kerja</label>
                                        <div class="col-sm-12 col-md-7">
                                            <input type="number" class="form-control" name="total_jam_kerja" required>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Total
                                            Gaji</label>
                                        <div class="col-sm-12 col-md-7">
                                            <input type="number" class="form-control" name="total_gaji" required>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Detail
                                            Perhitungan</label>
                                        <div class="col-sm-12 col-md-7">
                                            <textarea class="form-control" name="detail_perhitungan"></textarea>
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
