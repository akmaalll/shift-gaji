@extends('layouts.app', ['title' => $menu])

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Cuti Saya</h1>
            <div class="section-header-button">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalCuti">
                    <i class="fas fa-plus"></i> Ajukan Cuti
                </button>
            </div>
        </div>

        <!-- Statistik -->
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="fas fa-plane"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Cuti</h4>
                        </div>
                        <div class="card-body">
                            {{ $totalCuti }}
                        </div>
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
                            <h4>Diajukan</h4>
                        </div>
                        <div class="card-body">
                            {{ $cutiDiajukan }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="fas fa-check"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Disetujui</h4>
                        </div>
                        <div class="card-body">
                            {{ $cutiDisetujui }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="fas fa-times"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Ditolak</h4>
                        </div>
                        <div class="card-body">
                            {{ $cutiDitolak }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Daftar Cuti -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Riwayat Cuti</h4>
                    </div>
                    <div class="card-body">
                        @if($cutiList->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Tanggal Mulai</th>
                                            <th>Tanggal Selesai</th>
                                            <th>Durasi</th>
                                            <th>Alasan</th>
                                            <th>Status</th>
                                            <th>Catatan Admin</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($cutiList as $cuti)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($cuti->tanggal_mulai)->format('d/m/Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($cuti->tanggal_selesai)->format('d/m/Y') }}</td>
                                            <td>{{ $cuti->durasi }} hari</td>
                                            <td>{{ $cuti->alasan }}</td>
                                            <td>
                                                @if($cuti->status == 'diajukan')
                                                    <span class="badge badge-warning">Diajukan</span>
                                                @elseif($cuti->status == 'disetujui')
                                                    <span class="badge badge-success">Disetujui</span>
                                                @elseif($cuti->status == 'ditolak')
                                                    <span class="badge badge-danger">Ditolak</span>
                                                @endif
                                            </td>
                                            <td>{{ $cuti->catatan_admin ?? '-' }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-plane fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Belum ada pengajuan cuti.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal Ajukan Cuti -->
<div class="modal fade" id="modalCuti" tabindex="-1" role="dialog" aria-labelledby="modalCutiLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('user.cuti.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCutiLabel">Ajukan Cuti</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Alasan</label>
                        <textarea name="alasan" class="form-control" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Ajukan Cuti</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
