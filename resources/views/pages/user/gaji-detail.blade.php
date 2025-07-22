@extends('layouts.app', ['title' => 'Detail Gaji'])
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Detail Gaji</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item">Gaji Saya</div>
                    <div class="breadcrumb-item">Detail</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Detail Gaji Bulan {{ $gaji->bulan }}</h4>
                                <div class="ml-auto">
                                    <a href="{{ route('user.gaji') }}" class="btn btn-secondary">Kembali</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td width="150"><strong>Bulan</strong></td>
                                                <td>: {{ $gaji->bulan }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Total Jam Kerja</strong></td>
                                                <td>: {{ $gaji->total_jam_kerja ?? 0 }} jam</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Gaji Pokok</strong></td>
                                                <td>: Rp {{ number_format($gaji->gaji_pokok ?? 0, 0, ',', '.') }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Gaji Lembur</strong></td>
                                                <td>: Rp {{ number_format($gaji->gaji_lembur ?? 0, 0, ',', '.') }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Total Gaji</strong></td>
                                                <td>: <strong>Rp
                                                        {{ number_format($gaji->total_gaji ?? 0, 0, ',', '.') }}</strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Status</strong></td>
                                                <td>:
                                                    @if ($gaji->status == 'draft')
                                                        <span class="badge badge-warning">Draft</span>
                                                    @elseif($gaji->status == 'dibayar')
                                                        <span class="badge badge-success">Dibayar</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>Ringkasan Perhitungan</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="text-center">
                                                            <h6>Jam Normal</h6>
                                                            <p class="text-muted">{{ $gaji->jam_normal ?? 0 }} jam</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="text-center">
                                                            <h6>Jam Lembur</h6>
                                                            <p class="text-muted">{{ $gaji->jam_lembur ?? 0 }} jam</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="text-center">
                                                            <h6>Rate Normal</h6>
                                                            <p class="text-muted">Rp
                                                                {{ number_format($gaji->rate_normal ?? 0, 0, ',', '.') }}/jam
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="text-center">
                                                            <h6>Rate Lembur</h6>
                                                            <p class="text-muted">Rp
                                                                {{ number_format($gaji->rate_lembur ?? 0, 0, ',', '.') }}/jam
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @if ($gaji->detail_perhitungan)
                                    <div class="row mt-4">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h5>Detail Perhitungan Harian</h5>
                                                </div>
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th>Tanggal</th>
                                                                    <th>Jam Kerja</th>
                                                                    <th>Gaji Shift</th>
                                                                    <th>Total</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @if (is_array($gaji->detail_perhitungan))
                                                                    @foreach ($gaji->detail_perhitungan as $detail)
                                                                        <tr>
                                                                            <td>{{ $detail['tanggal'] ?? '-' }}</td>
                                                                            <td>{{ $detail['jam_kerja'] ?? 0 }} jam</td>
                                                                            <td>Rp
                                                                                {{ number_format($detail['gaji_per_shift'] ?? 0, 0, ',', '.') }}
                                                                            </td>
                                                                            <td>Rp
                                                                                {{ number_format($detail['total_gaji_shift'] ?? 0, 0, ',', '.') }}
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                @else
                                                                    <tr>
                                                                        <td colspan="7" class="text-center">Tidak ada
                                                                            detail perhitungan</td>
                                                                    </tr>
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
