@extends('layouts.app', ['title' => 'Validasi Jadwal Shift'])
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Validasi Jadwal Shift</h1>
                <div class="section-header-button">
                    <a href="{{ route('admin.shift.dashboard') }}" class="btn btn-primary">
                        <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Hasil Validasi Jadwal</h4>
                            <div class="card-header-action">
                                @if ($valid)
                                    <span class="badge badge-success">
                                        <i class="fas fa-check-circle"></i> Jadwal Valid
                                    </span>
                                @else
                                    <span class="badge badge-danger">
                                        <i class="fas fa-exclamation-triangle"></i> Ditemukan Konflik
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                            @if ($valid)
                                <div class="alert alert-success">
                                    <i class="fas fa-check-circle"></i>
                                    <strong>Jadwal Valid!</strong> Tidak ditemukan konflik dalam jadwal shift untuk periode
                                    yang dipilih.
                                </div>
                            @else
                                <div class="alert alert-danger">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    <strong>Ditemukan Konflik!</strong> Berikut adalah daftar konflik yang ditemukan dalam
                                    jadwal shift.
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>Jenis Konflik</th>
                                                <th>Detail</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($conflicts as $conflict)
                                                <tr>
                                                    <td>
                                                        <strong>{{ \Carbon\Carbon::parse($conflict['tanggal'])->format('d/m/Y') }}</strong>
                                                    </td>
                                                    <td>
                                                        @if ($conflict['jenis'] == 'multiple_shifts_per_day')
                                                            <span class="badge badge-warning">
                                                                <i class="fas fa-exclamation"></i> Multiple Shift per Hari
                                                            </span>
                                                        @elseif($conflict['jenis'] == 'insufficient_staff')
                                                            <span class="badge badge-info">
                                                                <i class="fas fa-users"></i> Staff Tidak Cukup
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($conflict['jenis'] == 'multiple_shifts_per_day')
                                                            <strong>{{ $conflict['user'] }}</strong> dijadwalkan
                                                            <strong>{{ $conflict['jumlah_shift'] }}</strong> shift dalam
                                                            satu hari
                                                        @elseif($conflict['jenis'] == 'insufficient_staff')
                                                            Shift <strong>{{ ucfirst($conflict['shift_type']) }}</strong>
                                                            hanya memiliki
                                                            <strong>{{ $conflict['jumlah_karyawan'] }}</strong> karyawan
                                                            (minimal 2 diperlukan)
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <span class="badge badge-danger">Perlu Perbaikan</span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="mt-4">
                                    <h6><i class="fas fa-lightbulb text-warning"></i> Saran Perbaikan:</h6>
                                    <ul>
                                        <li>Periksa jadwal karyawan yang memiliki multiple shift per hari</li>
                                        <li>Pastikan setiap shift memiliki minimal 2 karyawan</li>
                                        <li>Gunakan fitur "Penjadwalan Otomatis" untuk memperbaiki jadwal</li>
                                        <li>Periksa status cuti karyawan yang mungkin mempengaruhi jadwal</li>
                                    </ul>
                                </div>
                            @endif

                            <div class="mt-4">
                                <h6>Informasi Validasi:</h6>
                                <ul>
                                    <li><strong>Periode:</strong>
                                        {{ $tanggal_mulai ? \Carbon\Carbon::parse($tanggal_mulai)->format('d/m/Y') : 'Awal bulan' }}
                                        -
                                        {{ $tanggal_selesai ? \Carbon\Carbon::parse($tanggal_selesai)->format('d/m/Y') : 'Akhir bulan' }}
                                    </li>
                                    <li><strong>Total Konflik:</strong> {{ count($conflicts) }}</li>
                                    <li><strong>Waktu Validasi:</strong> {{ now()->format('d/m/Y H:i:s') }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <a href="{{ route('admin.shift.index') }}" class="btn btn-primary btn-block">
                                        <i class="fas fa-list"></i> Lihat Semua Shift
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <a href="{{ route('admin.shift.dashboard') }}" class="btn btn-info btn-block">
                                        <i class="fas fa-chart-bar"></i> Dashboard Shift
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <form action="{{ route('admin.shift.penjadwalan-otomatis') }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        <input type="hidden" name="tanggal_mulai" value="{{ $tanggal_mulai }}">
                                        <input type="hidden" name="tanggal_selesai" value="{{ $tanggal_selesai }}">
                                        <button type="submit" class="btn btn-success btn-block">
                                            <i class="fas fa-magic"></i> Perbaiki Otomatis
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
