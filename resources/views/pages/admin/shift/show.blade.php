@extends('layouts.app')

@section('title', 'Detail Shift')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Detail Shift</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('admin.shift.index') }}">Shift</a></div>
                    <div class="breadcrumb-item">Detail</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Informasi Shift</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td width="150"><strong>Tanggal Shift</strong></td>
                                                <td>: {{ date('d/m/Y', strtotime($shift->tanggal_shift)) }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Jenis Shift</strong></td>
                                                <td>: {{ ucfirst($shift->jenis_shift) }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Jam Mulai</strong></td>
                                                <td>: {{ $shift->jam_mulai ? $shift->jam_mulai->format('H:i') : '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Jam Selesai</strong></td>
                                                <td>: {{ $shift->jam_selesai ? $shift->jam_selesai->format('H:i') : '-' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Karyawan</strong></td>
                                                <td>: {{ $shift->user->name ?? 'Belum diassign' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Status</strong></td>
                                                <td>:
                                                    @if ($shift->status == 'kosong')
                                                        <span class="badge badge-secondary">Kosong</span>
                                                    @elseif($shift->status == 'diambil')
                                                        <span class="badge badge-info">Diambil</span>
                                                    @elseif($shift->status == 'selesai')
                                                        <span class="badge badge-success">Selesai</span>
                                                    @elseif($shift->status == 'dibatalkan')
                                                        <span class="badge badge-danger">Dibatalkan</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Keterangan</strong></td>
                                                <td>: {{ $shift->keterangan ?? 'Tidak ada keterangan' }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <a href="{{ route('admin.shift.index') }}" class="btn btn-secondary">Kembali</a>
                                <a href="{{ route('admin.shift.edit', $shift->id) }}" class="btn btn-primary">Edit</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
