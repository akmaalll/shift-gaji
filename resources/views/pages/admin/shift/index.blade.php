@extends('layouts.app', ['title' => $menu])

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ $menu }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item">{{ $menu }}</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Data {{ $menu }}</h4>
                                <div class="ml-auto">
                                    <!-- Form Penjadwalan Otomatis dengan Range Tanggal -->
                                    <form action="{{ route('admin.shift.penjadwalanOtomatis') }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        <button class="btn btn-info" type="submit"
                                            @if (!$boleh_penjadwalan) disabled @endif
                                            onclick="return confirm('Jalankan penjadwalan shift otomatis untuk minggu ini?')">
                                            <i class="fas fa-magic"></i> Penjadwalan Otomatis
                                        </button>
                                    </form>
                                    @if (!$boleh_penjadwalan)
                                        <div class="alert alert-warning mt-2">
                                            Penjadwalan shift otomatis hanya bisa dilakukan jika terdapat minimal 7 shift
                                            kosong.<br>
                                            Jumlah shift kosong saat ini: <b>{{ $jumlah_shift_kosong }}</b><br>
                                            Silakan tambah shift hingga minimal 7 shift kosong agar penjadwalan otomatis
                                            bisa dilakukan.
                                        </div>
                                    @endif
                                    <a href="{{ route('admin.shift.create') }}" class="btn btn-primary">Tambah Data</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="table-1">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Tanggal</th>
                                                <th>Jenis Shift</th>
                                                <th>Jam</th>
                                                <th>Karyawan</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($shifts as $shift)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
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
                                                        @if ($shift->user)
                                                            {{ $shift->user->nama_lengkap }}
                                                        @else
                                                            <span class="text-muted">-</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($shift->status == 'kosong')
                                                            <span class="badge badge-secondary">Kosong</span>
                                                        @elseif($shift->status == 'diambil')
                                                            <span class="badge badge-warning">Diambil</span>
                                                        @elseif($shift->status == 'selesai')
                                                            <span class="badge badge-success">Selesai</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('admin.shift.show', $shift->id) }}"
                                                            class="btn btn-sm btn-info">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('admin.shift.edit', $shift->id) }}"
                                                            class="btn btn-sm btn-warning">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('admin.shift.destroy', $shift->id) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger"
                                                                onclick="return confirm('Yakin ingin menghapus shift ini?')">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
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
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('library/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('library/datatables.net-select-bs4/js/select.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/page/modules-datatables.js') }}"></script>
@endpush
