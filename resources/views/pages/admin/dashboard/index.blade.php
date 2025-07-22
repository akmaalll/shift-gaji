@extends('layouts.app', ['title' => 'Dashboard'])

@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('library/weathericons/css/weather-icons.min.css') }}">
        <link rel="stylesheet" href="{{ asset('library/weathericons/css/weather-icons-wind.min.css') }}">
        <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.css') }}">
    @endpush

    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Dashboard</h1>
            </div>
            <div class="row">
                @if (auth()->user()->role == 'admin')
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-primary">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Total Karyawan</h4>
                                </div>
                                <div class="card-body">
                                    {{ $totalKaryawan ?? 0 }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-success">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Total Shift</h4>
                                </div>
                                <div class="card-body">
                                    {{ $totalShift ?? 0 }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-warning">
                                <i class="fas fa-user-clock"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Shift Kosong</h4>
                                </div>
                                <div class="card-body">
                                    {{ $shiftKosong ?? 0 }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-danger">
                                <i class="fas fa-money-bill-wave"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Total Gaji Bulan Ini</h4>
                                </div>
                                <div class="card-body">
                                    Rp {{ number_format($totalGajiBulanIni ?? 0, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-primary">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Shift Saya Bulan Ini</h4>
                                </div>
                                <div class="card-body">
                                    {{ $shiftSaya ?? 0 }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-success">
                                <i class="fas fa-plane-departure"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Cuti Saya</h4>
                                </div>
                                <div class="card-body">
                                    {{ $cutiSaya ?? 0 }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-danger">
                                <i class="fas fa-money-check-alt"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Gaji Bulan Ini</h4>
                                </div>
                                <div class="card-body">
                                    Rp {{ number_format($gajiSayaBulanIni ?? 0, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </section>
    </div>

    @push('scripts')
        <script src="{{ asset('library/simpleweather/jquery.simpleWeather.min.js') }}"></script>
        <script src="{{ asset('library/chart.js/dist/Chart.min.js') }}"></script>
        <script src="{{ asset('library/jqvmap/dist/jquery.vmap.min.js') }}"></script>
        <script src="{{ asset('library/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
        <script src="{{ asset('library/summernote/dist/summernote-bs4.js') }}"></script>
        <script src="{{ asset('library/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>
        <!-- Page Specific JS File -->
        <script src="{{ asset('js/page/index-0.js') }}"></script>
    @endpush
@endsection
    