@extends('layouts.app')

@section('title', 'Detail Cuti')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Detail Cuti</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('admin.cuti.index') }}">Cuti</a></div>
                    <div class="breadcrumb-item">Detail</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Informasi Cuti</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td width="150"><strong>Karyawan</strong></td>
                                                <td>: {{ $cuti->user->name ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Jenis Cuti</strong></td>
                                                <td>: {{ ucfirst($cuti->jenis_cuti) }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Tanggal Mulai</strong></td>
                                                <td>: {{ date('d/m/Y', strtotime($cuti->tanggal_mulai)) }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Tanggal Selesai</strong></td>
                                                <td>: {{ date('d/m/Y', strtotime($cuti->tanggal_selesai)) }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Durasi</strong></td>
                                                <td>: {{ $cuti->durasi }} hari</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Status</strong></td>
                                                <td>:
                                                    @if ($cuti->status == 'pending')
                                                        <span class="badge badge-warning">Pending</span>
                                                    @elseif($cuti->status == 'disetujui')
                                                        <span class="badge badge-success">Disetujui</span>
                                                    @elseif($cuti->status == 'ditolak')
                                                        <span class="badge badge-danger">Ditolak</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Alasan</strong></td>
                                                <td>: {{ $cuti->alasan }}</td>
                                            </tr>
                                            @if ($cuti->catatan_admin)
                                                <tr>
                                                    <td><strong>Catatan Admin</strong></td>
                                                    <td>: {{ $cuti->catatan_admin }}</td>
                                                </tr>
                                            @endif
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <a href="{{ route('admin.cuti.index') }}" class="btn btn-secondary">Kembali</a>
                                <a href="{{ route('admin.cuti.edit', $cuti->id) }}" class="btn btn-primary">Edit</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
