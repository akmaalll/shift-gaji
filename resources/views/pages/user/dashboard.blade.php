@extends('layouts.app', ['title' => $menu])

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Dashboard</h1>
            </div>

            <!-- Statistik -->
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Shift Tersedia</h4>
                            </div>
                            <div class="card-body">
                                {{ $totalShiftKosong }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                            <i class="fas fa-user-clock"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Shift Diambil</h4>
                            </div>
                            <div class="card-body">
                                {{ $totalShiftDiambil }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Shift Selesai</h4>
                            </div>
                            <div class="card-body">
                                {{ $totalShiftSelesai }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-info">
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
            </div>

            <!-- Shift Terbaru -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Shift Terbaru</h4>
                        </div>
                        <div class="card-body">
                            @if ($recentShifts->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>Jenis Shift</th>
                                                <th>Jam</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($recentShifts as $shift)
                                                <tr>
                                                    <td>{{ \Carbon\Carbon::parse($shift->tanggal_shift)->format('d/m/Y') }}
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="badge badge-{{ $shift->jenis_shift == 'pagi' ? 'info' : 'dark' }}">
                                                            {{ ucfirst($shift->jenis_shift) }}
                                                        </span>
                                                    </td>
                                                    <td>{{ $shift->jam_mulai ? $shift->jam_mulai->format('H:i') : '-' }} -
                                                        {{ $shift->jam_selesai ? $shift->jam_selesai->format('H:i') : '-' }}
                                                    </td>
                                                    <td>
                                                        @if ($shift->status == 'diambil')
                                                            <span class="badge badge-warning">Diambil</span>
                                                        @elseif($shift->status == 'selesai')
                                                            <span class="badge badge-success">Selesai</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-user-clock fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">Belum ada shift yang diambil.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
