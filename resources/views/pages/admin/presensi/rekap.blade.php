@extends('layouts.app', ['title' => $menu])

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Rekap Presensi</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('admin.presensi.index') }}">Presensi</a></div>
                    <div class="breadcrumb-item">Rekap</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Filter Rekap Presensi</h4>
                            </div>
                            <div class="card-body">
                                <form method="GET" action="{{ route('admin.presensi.rekap') }}">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Bulan</label>
                                                <input type="month" name="bulan" class="form-control"
                                                    value="{{ $bulan }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Karyawan</label>
                                                <select name="karyawan_id" class="form-control">
                                                    <option value="">Semua Karyawan</option>
                                                    @foreach ($karyawanList as $k)
                                                        <option value="{{ $k->id }}"
                                                            {{ $karyawan == $k->id ? 'selected' : '' }}>
                                                            {{ $k->nama_lengkap }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>&nbsp;</label>
                                                <button type="submit" class="btn btn-primary btn-block">Filter</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Rekap Presensi {{ date('F Y', strtotime($bulan . '-01')) }}</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Tanggal</th>
                                                <th>Karyawan</th>
                                                <th>Shift</th>
                                                <th>Jam Masuk</th>
                                                <th>Jam Keluar</th>
                                                <th>Status</th>
                                                <th>Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($presensi as $index => $p)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ date('d/m/Y', strtotime($p->tanggal_presensi)) }}</td>
                                                    <td>{{ $p->user->nama_lengkap }}</td>
                                                    <td>{{ ucfirst($p->shift->jenis_shift ?? 'N/A') }}
                                                        ({{ $p->shift->jam_mulai ? $p->shift->jam_mulai->format('H:i') : '-' }}
                                                        -
                                                        {{ $p->shift->jam_selesai ? $p->shift->jam_selesai->format('H:i') : '-' }})
                                                    </td>
                                                    <td>{{ $p->jam_masuk ? $p->jam_masuk->format('H:i') : '-' }}</td>
                                                    <td>{{ $p->jam_keluar ? $p->jam_keluar->format('H:i') : '-' }}</td>
                                                    <td>
                                                        @if ($p->status == 'hadir')
                                                            <span class="badge badge-success">Hadir</span>
                                                        @elseif($p->status == 'izin')
                                                            <span class="badge badge-warning">Izin</span>
                                                        @elseif($p->status == 'sakit')
                                                            <span class="badge badge-info">Sakit</span>
                                                        @elseif($p->status == 'alpha')
                                                            <span class="badge badge-danger">Alpha</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $p->keterangan ?? '-' }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="8" class="text-center">Tidak ada data presensi untuk
                                                        periode ini</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                @if ($presensi->count() > 0)
                                    <div class="row mt-4">
                                        <div class="col-md-12">
                                            <h6>Statistik Presensi:</h6>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="card bg-success text-white">
                                                        <div class="card-body">
                                                            <h5>{{ $presensi->where('status', 'hadir')->count() }}</h5>
                                                            <p>Hadir</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="card bg-warning text-white">
                                                        <div class="card-body">
                                                            <h5>{{ $presensi->where('status', 'izin')->count() }}</h5>
                                                            <p>Izin</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="card bg-info text-white">
                                                        <div class="card-body">
                                                            <h5>{{ $presensi->where('status', 'sakit')->count() }}</h5>
                                                            <p>Sakit</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="card bg-danger text-white">
                                                        <div class="card-body">
                                                            <h5>{{ $presensi->where('status', 'alpha')->count() }}</h5>
                                                            <p>Alpha</p>
                                                        </div>
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
