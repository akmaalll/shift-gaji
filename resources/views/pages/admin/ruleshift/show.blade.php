@extends('layouts.app')

@section('title', 'Detail Rule Shift')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Detail Rule Shift</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('admin.ruleshift.index') }}">Rule Shift</a></div>
                    <div class="breadcrumb-item">Detail</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Informasi Rule Shift</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td width="150"><strong>Nama Rule</strong></td>
                                                <td>: {{ $ruleshift->nama_rule }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Jenis Shift</strong></td>
                                                <td>: {{ ucfirst($ruleshift->jenis_shift) }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Durasi (Jam)</strong></td>
                                                <td>: {{ $ruleshift->durasi_jam }} jam</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Prioritas</strong></td>
                                                <td>: {{ $ruleshift->prioritas }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Status</strong></td>
                                                <td>:
                                                    @if ($ruleshift->status == 'aktif')
                                                        <span class="badge badge-success">Aktif</span>
                                                    @else
                                                        <span class="badge badge-secondary">Nonaktif</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Deskripsi</strong></td>
                                                <td>: {{ $ruleshift->deskripsi ?? 'Tidak ada deskripsi' }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <a href="{{ route('admin.ruleshift.index') }}" class="btn btn-secondary">Kembali</a>
                                <a href="{{ route('admin.ruleshift.edit', $ruleshift->id) }}"
                                    class="btn btn-primary">Edit</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
