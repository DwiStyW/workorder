@extends('layouts.master-without-nav')
@section('title')
    Register
@endsection
@section('content')
    <div class="home-btn d-none d-sm-block">
        <a href="{{ url('index') }}" class="text-dark"><i class="mdi mdi-home-variant h2"></i></a>
    </div>
    <div class="account-pages my-5 pt-sm-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center">
                        <a href="{{ url('index') }}" class="mb-5 d-block auth-logo">
                            <img src="{{ URL::asset('/assets/images/logo-dark.png') }}" alt="" height="22"
                                class="logo logo-dark">
                            <img src="{{ URL::asset('/assets/images/logo-light.png') }}" alt="" height="22"
                                class="logo logo-light">
                        </a>
                    </div>
                </div>
            </div>
            <div class="row align-items-center justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card">

                        <div class="card-body p-4">

                            <div class="text-center mt-2">
                                <h5 class="text-primary">Register Account</h5>
                                <p class="text-muted">Get your free Minible account now.</p>
                            </div>
                            <div class="p-2 mt-4">
                                <form method="POST" action="{{ route('register') }}">
                                    @csrf

                                    <div class="mb-3">
                                        <label class="form-label" for="email">Email</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            name="email" value="{{ old('email') }}" id="email"
                                            placeholder="Enter email">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="username">Username</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            name="name" value="{{ old('name') }}" id="username"
                                            placeholder="Enter username">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="divisi">Divisi</label>
                                        <select class="form-control selectize" name="divisi" id="divisi">
                                            <option value="" disabled selected>Pilih Divisi</option>
                                            <option value="TEK">Teknik</option>
                                            <option value="QC">Quality Control</option>
                                            <option value="GUD">Gudang</option>
                                            <option value="PRO">Produksi</option>
                                            <option value="PPC">PPIC</option>
                                            <option value="IT">IT</option>
                                        </select>
                                        @error('divisi')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="role">Role</label>
                                        <select class="form-control selectize" name="role" id="role">
                                            <option value="" disabled selected>Pilih Role</option>
                                            <option value="admin">Admin</option>
                                            <option value="employee">Employee</option>
                                            <option value="user">User</option>
                                            <option value="kabag">Kepala Bagian</option>
                                            <option value="manager">Manager</option>
                                        </select>
                                        @error('role')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="userpassword">Password</label>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                                            name="password" id="userpassword" placeholder="Enter password">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="password_confirmation">Confirm Password</label>
                                        <input type="password"
                                            class="form-control @error('password_confirmation') is-invalid @enderror"
                                            name="password_confirmation" id="password_confirmation"
                                            placeholder="Enter confirm password">
                                        @error('password_confirmation')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>


                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="auth-terms-condition-check">
                                        <label class="form-check-label" for="auth-terms-condition-check">I accept <a
                                                href="javascript: void(0);" class="text-dark">Terms and
                                                Conditions</a></label>
                                    </div>

                                    <div class="mt-3 text-end">
                                        <button class="btn btn-primary w-sm waves-effect waves-light"
                                            type="submit">Register</button>
                                    </div>


                                    <div class="mt-4 text-center">
                                        <p class="text-muted mb-0">Already have an account ? <a
                                                href="{{ url('login') }}" class="fw-medium text-primary"> Login</a></p>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                    <div class="mt-5 text-center">
                        <p>©
                            <script>
                                document.write(new Date().getFullYear())
                            </script> Minible. Crafted with <i class="mdi mdi-heart text-danger"></i> by
                            Themesbrand
                        </p>
                    </div>

                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
@endsection
@section('script')
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.bootstrap5.min.css" />
    <script src="{{ URL::asset('/assets/js/selectize.min.js') }}"></script>
    <script>
        // console.log('test');
        $(document).ready(function() {
            $('.selectize').selectize();
        });
    </script>
@endsection
