@extends('layouts.app')

@section('title', 'Detail Presensi')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Detail Presensi</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('admin.presensi.index') }}">Presensi</a></div>
                    <div class="breadcrumb-item">Detail</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Informasi Presensi</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td width="150"><strong>Karyawan</strong></td>
                                                <td>: {{ $presensi->user->nama_lengkap }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Jabatan</strong></td>
                                                <td>: {{ $presensi->user->jabatan ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Tanggal Presensi</strong></td>
                                                <td>: {{ date('d/m/Y', strtotime($presensi->tanggal_presensi)) }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Shift</strong></td>
                                                <td>: {{ ucfirst($presensi->shift->jenis_shift ?? 'N/A') }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Jam Shift</strong></td>
                                                <td>:
                                                    {{ $presensi->shift->jam_mulai ? $presensi->shift->jam_mulai->format('H:i') : '-' }}
                                                    -
                                                    {{ $presensi->shift->jam_selesai ? $presensi->shift->jam_selesai->format('H:i') : '-' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Status</strong></td>
                                                <td>:
                                                    @if ($presensi->status == 'hadir')
                                                        <span class="badge badge-success">Hadir</span>
                                                    @elseif($presensi->status == 'izin')
                                                        <span class="badge badge-warning">Izin</span>
                                                    @elseif($presensi->status == 'sakit')
                                                        <span class="badge badge-info">Sakit</span>
                                                    @elseif($presensi->status == 'alpha')
                                                        <span class="badge badge-danger">Alpha</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Jam Masuk</strong></td>
                                                <td>: {{ $presensi->jam_masuk ? $presensi->jam_masuk->format('H:i') : '-' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Jam Keluar</strong></td>
                                                <td>:
                                                    {{ $presensi->jam_keluar ? $presensi->jam_keluar->format('H:i') : '-' }}
                                                </td>
                                            </tr>
                                            @if ($presensi->keterangan)
                                                <tr>
                                                    <td><strong>Keterangan</strong></td>
                                                    <td>: {{ $presensi->keterangan }}</td>
                                                </tr>
                                            @endif
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <a href="{{ route('admin.presensi.index') }}" class="btn btn-secondary">Kembali</a>
                                <a href="{{ route('admin.presensi.edit', $presensi->id) }}"
                                    class="btn btn-primary">Edit</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
