@extends('layouts.app', ['title' => $menu])
@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('library/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('library/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
    @endpush
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
                                    <a href="{{ route('admin.rule-gaji.create') }}" class="btn btn-primary">Tambah Data</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="table-1">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Rule</th>
                                                <th>Deskripsi</th>
                                                <th>Gaji per Shift</th>
                                                <th>Jam Kerja per Shift</th>
                                                <th>Rate Lembur per Jam</th>
                                                <th>Aktif</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($rulegaji as $v)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $v->nama_rule }}</td>
                                                    <td>{{ Str::limit($v->deskripsi, 50) }}</td>
                                                    <td>Rp {{ number_format($v->gaji_per_shift, 0, ',', '.') }}</td>
                                                    <td>{{ $v->jam_kerja_per_shift }} jam</td>
                                                    <td>Rp {{ number_format($v->rate_lembur_per_jam, 0, ',', '.') }}</td>
                                                    <td>
                                                        @if ($v->aktif)
                                                            <span class="badge badge-success">Aktif</span>
                                                        @else
                                                            <span class="badge badge-secondary">Tidak Aktif</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('admin.rule-gaji.show', $v->id) }}"
                                                            class="btn btn-sm btn-info">Detail</a>
                                                        <a href="{{ route('admin.rule-gaji.edit', $v->id) }}"
                                                            class="btn btn-sm btn-warning">Edit</a>
                                                        <form action="{{ route('admin.rule-gaji.destroy', $v->id) }}"
                                                            method="POST" class="d-inline"
                                                            onsubmit="return confirm('Yakin ingin menghapus rule gaji ini?')">
                                                            @csrf
                                                            @method('delete')
                                                            <button type="submit"
                                                                class="btn btn-sm btn-danger">Hapus</button>
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
    @push('scripts')
        <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('library/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('library/datatables.net-select-bs4/js/select.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('js/page/modules-datatables.js') }}"></script>
    @endpush
@endsection
