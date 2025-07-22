@extends('layouts.app', ['title' => 'Shift Kosong'])
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Daftar Shift Kosong</h1>
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
                            <h4>Shift Kosong yang Tersedia</h4>
                            <div class="card-header-action">
                                <span class="badge badge-warning">
                                    <i class="fas fa-clock"></i> {{ $shifts->count() }} Shift Kosong
                                </span>
                            </div>
                        </div>
                        <div class="card-body">
                            @if ($shifts->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Tanggal</th>
                                                <th>Jenis Shift</th>
                                                <th>Jam Kerja</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($shifts as $index => $shift)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>
                                                        <strong>{{ \Carbon\Carbon::parse($shift->tanggal_shift)->format('d/m/Y') }}</strong>
                                                        <br>
                                                        <small class="text-muted">
                                                            {{ \Carbon\Carbon::parse($shift->tanggal_shift)->format('l') }}
                                                        </small>
                                                    </td>
                                                    <td>
                                                        @if ($shift->jenis_shift == 'pagi')
                                                            <span class="badge badge-primary">
                                                                <i class="fas fa-sun"></i> Pagi
                                                            </span>
                                                        @elseif($shift->jenis_shift == 'siang')
                                                            <span class="badge badge-warning">
                                                                <i class="fas fa-cloud-sun"></i> Siang
                                                            </span>
                                                        @else
                                                            <span class="badge badge-dark">
                                                                <i class="fas fa-moon"></i> Malam
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <strong>{{ $shift->jam_mulai ? $shift->jam_mulai->format('H:i') : '-' }}</strong>
                                                        -
                                                        <strong>{{ $shift->jam_selesai ? $shift->jam_selesai->format('H:i') : '-' }}</strong>
                                                        <br>
                                                        <small class="text-muted">
                                                            @php
                                                                $start = $shift->jam_mulai
                                                                    ? \Carbon\Carbon::parse($shift->jam_mulai)
                                                                    : null;
                                                                $end = $shift->jam_selesai
                                                                    ? \Carbon\Carbon::parse($shift->jam_selesai)
                                                                    : null;
                                                                $duration =
                                                                    $start && $end ? $start->diffInHours($end) : 0;
                                                            @endphp
                                                            {{ $duration }} jam
                                                        </small>
                                                    </td>
                                                    <td>
                                                        <span class="badge badge-warning">
                                                            <i class="fas fa-clock"></i> Kosong
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group" role="group">
                                                            <a href="{{ route('admin.shift.edit', $shift->id) }}"
                                                                class="btn btn-sm btn-info" title="Edit Shift">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <button type="button" class="btn btn-sm btn-success"
                                                                onclick="assignShift({{ $shift->id }})"
                                                                title="Assign Karyawan">
                                                                <i class="fas fa-user-plus"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Statistik Shift Kosong -->
                                <div class="row mt-4">
                                    <div class="col-md-4">
                                        <div class="card card-statistic-1">
                                            <div class="card-icon bg-warning">
                                                <i class="fas fa-sun"></i>
                                            </div>
                                            <div class="card-wrap">
                                                <div class="card-header">
                                                    <h4>Shift Pagi Kosong</h4>
                                                </div>
                                                <div class="card-body">
                                                    {{ $shifts->where('jenis_shift', 'pagi')->count() }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card card-statistic-1">
                                            <div class="card-icon bg-warning">
                                                <i class="fas fa-cloud-sun"></i>
                                            </div>
                                            <div class="card-wrap">
                                                <div class="card-header">
                                                    <h4>Shift Siang Kosong</h4>
                                                </div>
                                                <div class="card-body">
                                                    {{ $shifts->where('jenis_shift', 'siang')->count() }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card card-statistic-1">
                                            <div class="card-icon bg-warning">
                                                <i class="fas fa-moon"></i>
                                            </div>
                                            <div class="card-wrap">
                                                <div class="card-header">
                                                    <h4>Shift Malam Kosong</h4>
                                                </div>
                                                <div class="card-body">
                                                    {{ $shifts->where('jenis_shift', 'malam')->count() }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                                    <h4 class="mt-3">Tidak Ada Shift Kosong</h4>
                                    <p class="text-muted">Semua shift sudah terisi dengan baik!</p>
                                    <a href="{{ route('admin.shift.dashboard') }}" class="btn btn-primary">
                                        <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tombol Aksi -->
            @if ($shifts->count() > 0)
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <form action="{{ route('admin.shift.penjadwalan-otomatis') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="tanggal_mulai"
                                                value="{{ request('tanggal_mulai', date('Y-m-d')) }}">
                                            <input type="hidden" name="tanggal_selesai"
                                                value="{{ request('tanggal_selesai', date('Y-m-d', strtotime('+1 week'))) }}">
                                            <button type="submit" class="btn btn-success btn-block">
                                                <i class="fas fa-magic"></i> Penjadwalan Otomatis
                                            </button>
                                        </form>
                                    </div>
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </section>
    </div>

    <!-- Modal Assign Karyawan -->
    <div class="modal fade" id="assignModal" tabindex="-1" role="dialog" aria-labelledby="assignModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="assignModalLabel">Assign Karyawan ke Shift</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="assignForm" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Pilih Karyawan</label>
                            <select name="user_id" class="form-control" required>
                                <option value="">Pilih Karyawan</option>
                                @foreach (\App\Models\User::where('role', 'karyawan')->get() as $user)
                                    <option value="{{ $user->id }}">{{ $user->nama_lengkap }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Assign</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function assignShift(shiftId) {
            $('#assignForm').attr('action', `/admin/shift/${shiftId}/assign`);
            $('#assignModal').modal('show');
        }
    </script>
@endsection
