@extends('layouts.app', ['title' => $menu ?? 'Rule Shift'])
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Rule Shift</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item">Rule Shift</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Data Rule Shift</h4>
                                <div class="ml-auto">
                                    <a href="{{ route('admin.ruleshift.create') }}" class="btn btn-primary">Tambah Rule</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Rule</th>
                                                <th>Deskripsi</th>
                                                <th>Max Shift/Bulan</th>
                                                <th>Min Jeda Hari</th>
                                                <th>Fairness</th>
                                                <th>Aktif</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($ruleshift as $v)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $v->nama_rule }}</td>
                                                    <td>{{ Str::limit($v->deskripsi, 50) }}</td>
                                                    <td>{{ $v->max_shift_per_bulan }} shift</td>
                                                    <td>{{ $v->min_jeda_hari }} hari</td>
                                                    <td>
                                                        @if ($v->fairness)
                                                            <span class="badge badge-success">Ya</span>
                                                        @else
                                                            <span class="badge badge-secondary">Tidak</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($v->aktif)
                                                            <span class="badge badge-success">Aktif</span>
                                                        @else
                                                            <span class="badge badge-secondary">Tidak Aktif</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('admin.ruleshift.show', $v->id) }}"
                                                            class="btn btn-sm btn-info">Detail</a>
                                                        <a href="{{ route('admin.ruleshift.edit', $v->id) }}"
                                                            class="btn btn-sm btn-warning">Edit</a>
                                                        <form action="{{ route('admin.ruleshift.destroy', $v->id) }}"
                                                            method="POST" class="d-inline"
                                                            onsubmit="return confirm('Yakin ingin menghapus rule shift ini?')">
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
@endsection
