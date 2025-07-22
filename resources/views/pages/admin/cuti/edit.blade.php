@extends('layouts.app', ['title' => 'Edit Cuti'])
@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    @endpush
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Cuti</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item">Cuti</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Edit Cuti</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.cuti.update', $cuti->id) }}" method="POST">
                                    @csrf
                                    @method('put')
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Karyawan</label>
                                        <div class="col-sm-12 col-md-7">
                                            <select class="form-control selectric" name="user_id" required>
                                                <option value="">Pilih Karyawan</option>
                                                @foreach ($users as $u)
                                                    <option value="{{ $u->id }}"
                                                        @if ($cuti->user_id == $u->id) selected @endif>
                                                        {{ $u->nama_lengkap }} ({{ $u->jabatan }})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Tanggal
                                            Mulai</label>
                                        <div class="col-sm-12 col-md-7">
                                            <input type="date" class="form-control" name="tanggal_mulai"
                                                value="{{ $data->tanggal_mulai }}" required>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Tanggal
                                            Selesai</label>
                                        <div class="col-sm-12 col-md-7">
                                            <input type="date" class="form-control" name="tanggal_selesai"
                                                value="{{ $data->tanggal_selesai }}" required>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Alasan</label>
                                        <div class="col-sm-12 col-md-7">
                                            <textarea class="form-control" name="alasan" required>{{ $data->alasan }}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Status</label>
                                        <div class="col-sm-12 col-md-7">
                                            <select class="form-control selectric" name="status">
                                                <option value="diajukan" @if ($data->status == 'diajukan') selected @endif>
                                                    Diajukan</option>
                                                <option value="disetujui" @if ($data->status == 'disetujui') selected @endif>
                                                    Disetujui</option>
                                                <option value="ditolak" @if ($data->status == 'ditolak') selected @endif>
                                                    Ditolak</option>
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
