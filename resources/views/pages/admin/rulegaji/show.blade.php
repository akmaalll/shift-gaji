@extends('layouts.app', ['title' => $menu])

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Detail Rule Gaji</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('admin.rule-gaji.index') }}">Rule Gaji</a></div>
                    <div class="breadcrumb-item">Detail</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Informasi Rule Gaji</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td width="150"><strong>Nama Rule</strong></td>
                                                <td>: {{ $rule_gaji->nama_rule }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Deskripsi</strong></td>
                                                <td>: {{ $rule_gaji->deskripsi ?? 'Tidak ada deskripsi' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Gaji per Shift</strong></td>
                                                <td>: Rp {{ number_format($rule_gaji->gaji_per_shift, 0, ',', '.') }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Jam Kerja per Shift</strong></td>
                                                <td>: {{ $rule_gaji->jam_kerja_per_shift }} jam</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Rate Lembur per Jam</strong></td>
                                                <td>: Rp {{ number_format($rule_gaji->rate_lembur_per_jam, 0, ',', '.') }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Status</strong></td>
                                                <td>:
                                                    @if ($rule_gaji->aktif)
                                                        <span class="badge badge-success">Aktif</span>
                                                    @else
                                                        <span class="badge badge-secondary">Nonaktif</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <a href="{{ route('admin.rule-gaji.index') }}" class="btn btn-secondary">Kembali</a>
                                <a href="{{ route('admin.rule-gaji.edit', $rule_gaji->id) }}"
                                    class="btn btn-primary">Edit</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
