@extends('layouts.app',  ['title' => $menu])

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Data Karyawan</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item">Karyawan</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Daftar Karyawan</h4>
                                <div class="card-header-action">
                                    <a href="{{ route('admin.karyawan.create') }}" class="btn btn-primary">Tambah
                                        Karyawan</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Lengkap</th>
                                                <th>Username</th>
                                                <th>Email</th>
                                                <th>Jabatan</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($karyawan as $index => $k)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $k->nama_lengkap }}</td>
                                                    <td>{{ $k->username }}</td>
                                                    <td>{{ $k->email }}</td>
                                                    <td>{{ $k->jabatan ?? '-' }}</td>
                                                    <td>
                                                        <a href="{{ route('admin.karyawan.show', $k->id) }}"
                                                            class="btn btn-sm btn-info">Detail</a>
                                                        <a href="{{ route('admin.karyawan.edit', $k->id) }}"
                                                            class="btn btn-sm btn-warning">Edit</a>
                                                        <form action="{{ route('admin.karyawan.destroy', $k->id) }}"
                                                            method="POST" class="d-inline"
                                                            onsubmit="return confirm('Yakin ingin menghapus karyawan ini?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="btn btn-sm btn-danger">Hapus</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center">Tidak ada data karyawan</td>
                                                </tr>
                                            @endforelse
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
