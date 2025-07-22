@extends('layouts.app')

@section('title', 'Detail Kinerja')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Detail Kinerja</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('admin.kinerja.index') }}">Kinerja</a></div>
                    <div class="breadcrumb-item">Detail</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Informasi Kinerja</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td width="150"><strong>Karyawan</strong></td>
                                                <td>: {{ $kinerja->user->name ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Bulan</strong></td>
                                                <td>: {{ $kinerja->bulan }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Tahun</strong></td>
                                                <td>: {{ $kinerja->tahun }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Nilai Kinerja</strong></td>
                                                <td>: {{ $kinerja->nilai_kinerja }}/100</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Kategori</strong></td>
                                                <td>:
                                                    @if ($kinerja->nilai_kinerja >= 90)
                                                        <span class="badge badge-success">Sangat Baik</span>
                                                    @elseif($kinerja->nilai_kinerja >= 80)
                                                        <span class="badge badge-info">Baik</span>
                                                    @elseif($kinerja->nilai_kinerja >= 70)
                                                        <span class="badge badge-warning">Cukup</span>
                                                    @else
                                                        <span class="badge badge-danger">Kurang</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Catatan</strong></td>
                                                <td>: {{ $kinerja->catatan ?? 'Tidak ada catatan' }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <a href="{{ route('admin.kinerja.index') }}" class="btn btn-secondary">Kembali</a>
                                <a href="{{ route('admin.kinerja.edit', $kinerja->id) }}" class="btn btn-primary">Edit</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
