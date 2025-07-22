@extends('layouts.auth', ['title' => 'Register'])
@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
        <link rel="stylesheet" href="{{ asset('library/izitoast/dist/css/iziToast.min.css') }}">
    @endpush

    <div class="card card-primary">
        <div class="card-header">
            <h4>Register</h4>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('store.register') }}">
                @csrf
                <div class="row">
                    <div class="form-group col-6">
                        <label for="username">Username</label>
                        <input id="username" type="text" class="form-control" name="username" autofocus>
                    </div>
                    <div class="form-group col-6">
                        <label for="nama_lengkap">Nama Lengkap</label>
                        <input id="nama_lengkap" type="text" class="form-control" name="nama_lengkap">
                    </div>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" class="form-control" name="email">
                    <div class="invalid-feedback">
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-6">
                        <label for="password" class="d-block">Password</label>
                        <input id="password" type="password" class="form-control " data-indicator="pwindicator"
                            name="password">
                        {{-- <div id="pwindicator" class="pwindicator">
                            <div class="bar"></div>
                            <div class="label"></div>
                        </div> --}}
                    </div>
                    <div class="form-group col-6">
                        <label for="password2" class="d-block">Password Confirmation</label>
                        <input id="password2" type="password" class="form-control" name="password-confirm">
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block">
                        Register
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('library/jquery-pwstrength/pwstrength.js') }}"></script>
        <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
        <script src="{{ asset('library/izitoast/dist/js/iziToast.min.js') }}"></script>
        <script src="{{ asset('js/page/modules-toastr.js') }}"></script>
        <script src="{{ asset('js/page/auth-register.js') }}"></script>
        <script>
            @if (session('success'))
                iziToast.success({
                    title: 'Sukses',
                    message: "{{ session('success') }}",
                    position: 'topRight'
                });
            @endif

            @if (session('error'))
                iziToast.error({
                    title: 'Error',
                    message: "{{ session('error') }}",
                    position: 'topRight'
                });
            @endif
        </script>
    @endpush
@endsection
