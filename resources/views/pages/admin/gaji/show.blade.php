@extends('layouts.app', ['title' => $menu])

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Detail Gaji</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('admin.gaji.index') }}">Gaji</a></div>
                    <div class="breadcrumb-item">Detail</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Informasi Gaji</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td width="150"><strong>Karyawan</strong></td>
                                                <td>: {{ $gaji->user->nama_lengkap ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Bulan</strong></td>
                                                <td>: {{ $gaji->bulan }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Total Shift</strong></td>
                                                <td>: {{ $gaji->total_shift ?? 0 }} shift</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Total Jam Lembur</strong></td>
                                                <td>: {{ $gaji->total_jam_lembur ?? 0 }} jam</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Total Gaji</strong></td>
                                                <td>: Rp {{ number_format($gaji->total_gaji ?? 0, 0, ',', '.') }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        @if ($gaji->detail_perhitungan)
                                            <h6>Detail Perhitungan Shift:</h6>
                                            <div class="table-responsive">
                                                <table class="table table-sm">
                                                    <thead>
                                                        <tr>
                                                            <th>Tanggal</th>
                                                            <th>Jam Kerja</th>
                                                            <th>Jam Lembur</th>
                                                            <th>Gaji Shift</th>
                                                            <th>Gaji Lembur</th>
                                                            <th>Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($gaji->detail_perhitungan as $detail)
                                                            <tr>
                                                                <td>{{ $detail['tanggal'] ?? '-' }}</td>
                                                                <td>{{ $detail['jam_kerja'] ?? 0 }} jam</td>
                                                                <td>{{ $detail['jam_lembur'] ?? 0 }} jam</td>
                                                                <td>Rp {{ number_format($detail['gaji_shift'] ?? 0, 0, ',', '.') }}</td>
                                                                <td>Rp {{ number_format($detail['gaji_lembur'] ?? 0, 0, ',', '.') }}</td>
                                                                <td>Rp {{ number_format($detail['total_gaji_shift'] ?? 0, 0, ',', '.') }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <a href="{{ route('admin.gaji.index') }}" class="btn btn-secondary">Kembali</a>
                                <a href="{{ route('admin.gaji.edit', $gaji->id) }}" class="btn btn-primary">Edit</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
