@extends('layouts.app', ['title' => $menu])

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Data Presensi</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item">Presensi</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Daftar Presensi</h4>
                                <div class="card-header-action">
                                    <a href="{{ route('admin.presensi.create') }}" class="btn btn-primary">Tambah
                                        Presensi</a>
                                    <a href="{{ route('admin.presensi.rekap') }}" class="btn btn-info">Rekap Presensi</a>
                                </div>
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
                                                <th>Aksi</th>
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
                                                    <td>
                                                        <a href="{{ route('admin.presensi.show', $p->id) }}"
                                                            class="btn btn-sm btn-info">Detail</a>
                                                        <a href="{{ route('admin.presensi.edit', $p->id) }}"
                                                            class="btn btn-sm btn-warning">Edit</a>
                                                        <form action="{{ route('admin.presensi.destroy', $p->id) }}"
                                                            method="POST" class="d-inline"
                                                            onsubmit="return confirm('Yakin ingin menghapus data presensi ini?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="btn btn-sm btn-danger">Hapus</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="8" class="text-center">Tidak ada data presensi</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                @if ($presensi->hasPages())
                                    <div class="d-flex justify-content-center">
                                        {{ $presensi->links() }}
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
