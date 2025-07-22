@extends('layouts.app', ['title' => 'Dashboard Shift'])
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Dashboard Shift</h1>
                <div class="section-header-button">
                    <a href="{{ route('admin.shift.index') }}" class="btn btn-primary">Kelola Shift</a>
                </div>
            </div>

            <!-- Statistik Cards -->
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-calendar"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Shift</h4>
                            </div>
                            <div class="card-body">{{ $totalShifts }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Shift Kosong</h4>
                            </div>
                            <div class="card-body">{{ $shiftsKosong }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-info">
                            <i class="fas fa-user-check"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Shift Diambil</h4>
                            </div>
                            <div class="card-body">{{ $shiftsDiambil }}</div>
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
                            <div class="card-body">{{ $shiftsSelesai }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Aksi Penjadwalan</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <form action="{{ route('admin.shift.penjadwalan-otomatis') }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label>Tanggal Mulai</label>
                                            <input type="date" name="tanggal_mulai" class="form-control"
                                                value="{{ date('Y-m-d') }}">
                                        </div>
                                        <div class="form-group">
                                            <label>Tanggal Selesai</label>
                                            <input type="date" name="tanggal_selesai" class="form-control"
                                                value="{{ date('Y-m-d', strtotime('+1 month')) }}">
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-block">
                                            <i class="fas fa-magic"></i> Penjadwalan Otomatis
                                        </button>
                                    </form>
                                </div>
                                <div class="col-md-4">
                                    <form action="{{ route('admin.shift.validasi-jadwal') }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label>Tanggal Mulai Validasi</label>
                                            <input type="date" name="tanggal_mulai" class="form-control"
                                                value="{{ date('Y-m-d') }}">
                                        </div>
                                        <div class="form-group">
                                            <label>Tanggal Selesai Validasi</label>
                                            <input type="date" name="tanggal_selesai" class="form-control"
                                                value="{{ date('Y-m-d', strtotime('+1 month')) }}">
                                        </div>
                                        <button type="submit" class="btn btn-warning btn-block">
                                            <i class="fas fa-search"></i> Validasi Jadwal
                                        </button>
                                    </form>
                                </div>
                                <div class="col-md-4">
                                    <form action="{{ route('admin.shift.shift-kosong') }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label>Tanggal Mulai</label>
                                            <input type="date" name="tanggal_mulai" class="form-control"
                                                value="{{ date('Y-m-d') }}">
                                        </div>
                                        <div class="form-group">
                                            <label>Tanggal Selesai</label>
                                            <input type="date" name="tanggal_selesai" class="form-control"
                                                value="{{ date('Y-m-d', strtotime('+1 week')) }}">
                                        </div>
                                        <button type="submit" class="btn btn-info btn-block">
                                            <i class="fas fa-list"></i> Lihat Shift Kosong
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistik Per Jenis Shift -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Statistik Per Jenis Shift</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Jenis Shift</th>
                                            <th>Jumlah</th>
                                            <th>Persentase</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($shiftsPerJenis as $jenis)
                                            <tr>
                                                <td>
                                                    <span
                                                        class="badge badge-{{ $jenis->jenis_shift == 'pagi' ? 'primary' : ($jenis->jenis_shift == 'siang' ? 'warning' : 'dark') }}">
                                                        {{ ucfirst($jenis->jenis_shift) }}
                                                    </span>
                                                </td>
                                                <td>{{ $jenis->total }}</td>
                                                <td>{{ $totalShifts > 0 ? round(($jenis->total / $totalShifts) * 100, 1) : 0 }}%
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Statistik Per Karyawan -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Top 10 Karyawan Terbanyak Shift</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Nama Karyawan</th>
                                            <th>Jumlah Shift</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($shiftsPerKaryawan as $karyawan)
                                            <tr>
                                                <td>{{ $karyawan->user->nama_lengkap ?? 'Unknown' }}</td>
                                                <td>
                                                    <span class="badge badge-primary">{{ $karyawan->total }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Aturan Penjadwalan -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Aturan Penjadwalan Shift</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6><i class="fas fa-list-ol text-primary"></i> Pembagian Shift Harian</h6>
                                    <ul>
                                        <li>Dalam satu hari, terdapat tiga shift: pagi, siang, dan malam</li>
                                        <li>Setiap shift membutuhkan minimal 2 karyawan</li>
                                        <li>Setiap karyawan dijadwalkan satu shift per hari</li>
                                    </ul>

                                    <h6><i class="fas fa-sync-alt text-warning"></i> Rotasi Shift</h6>
                                    <ul>
                                        <li>Karyawan akan diputar secara bergilir setiap minggu</li>
                                        <li>Jika minggu lalu malam, minggu ini prioritas pagi/siang</li>
                                        <li>Sistem memastikan keadilan dalam pembagian shift</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <h6><i class="fas fa-user-plus text-success"></i> Pengisian Shift Kosong</h6>
                                    <ul>
                                        <li>Shift kosong ditampilkan di daftar "shift darurat"</li>
                                        <li>Karyawan dapat memilih shift kosong secara sukarela</li>
                                        <li>Sistem validasi eligibility sebelum pengambilan</li>
                                    </ul>

                                    <h6><i class="fas fa-calendar-times text-danger"></i> Penanganan Cuti</h6>
                                    <ul>
                                        <li>Karyawan cuti tidak dijadwalkan selama periode cuti</li>
                                        <li>Shift kosong akibat cuti masuk daftar darurat</li>
                                        <li>Validasi otomatis untuk mencegah konflik</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
