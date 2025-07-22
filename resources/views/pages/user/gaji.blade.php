@extends('layouts.app', ['title' => $menu])

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Gaji Saya</h1>
            </div>

            <!-- Statistik -->
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Gaji</h4>
                            </div>
                            <div class="card-body">
                                Rp {{ number_format($totalGaji, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Gaji Bulan Ini</h4>
                            </div>
                            <div class="card-body">
                                Rp {{ number_format($gajiBulanIni, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-info">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Shift</h4>
                            </div>
                            <div class="card-body">
                                {{ $totalShift }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Daftar Gaji -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Riwayat Gaji</h4>
                        </div>
                        <div class="card-body">
                            @if ($gajiList->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Bulan</th>
                                                <th>Total Shift</th>
                                                <th>Total Jam Lembur</th>
                                                <th>Total Gaji</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($gajiList as $gaji)
                                                <tr>
                                                    <td>{{ \Carbon\Carbon::parse($gaji->bulan)->format('F Y') }}</td>
                                                    <td>{{ $gaji->total_shift ?? 0 }} shift</td>
                                                    <td>{{ $gaji->total_jam_lembur ?? 0 }} jam</td>
                                                    <td>Rp {{ number_format($gaji->total_gaji ?? 0, 0, ',', '.') }}</td>
                                                    <td>
                                                        <a href="{{ route('user.gaji.detail', $gaji->id) }}"
                                                            class="btn btn-sm btn-info">
                                                            <i class="fas fa-eye"></i> Detail
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-money-bill-wave fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">Belum ada data gaji.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
