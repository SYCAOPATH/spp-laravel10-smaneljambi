@extends('layouts.default')

@section('content')
    @if (Auth::guard('siswa')->check())
        Hi {{ Auth::guard('siswa')->user()->nama }}
    @endif
    {{-- <section class="h-100 gradient-form" style="background-color: #eee;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-xl-10">
                    <div class="card rounded-3 text-black">
                        <div class="row g-0">
                            <div class="col-lg-6">
                                <div class="card-body p-md-5 mx-md-4">

                                    <div class="text-center">
                                        <img src="{{ asset('assets/img/logo.png') }}" style="width: 100px;" alt="logo">
                                        <h4 class="mt-1 mb-5 pb-1">Aplikasi Pembayaran SPP</h4>
                                    </div>

                                    <form action="" method="post" class="login100-form validate-form">
                                        @csrf
                                        <p>Please login to your account</p>

                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="username">Username</label>
                                            <input type="email" id="username" name="username" class="form-control"
                                                placeholder="Username" />
                                            <p class="mt-1" style="font-size: 10px;">Note: <i>Untuk siswa masukan username
                                                    dengan NISN!</i></p>
                                        </div>

                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="password">Password</label>
                                            <input type="password" id="password" name="password" class="form-control"
                                                placeholder="Password" />
                                        </div>

                                        <div class="text-center pt-1 mb-5 pb-1">
                                            <button class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3"
                                                type="button">Log
                                                in</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                            <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
                                <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                                    <h4 class="mb-4">Aplikasi Pembayaran SPP</h4>
                                    <p class="small mb-0">Aplikasi ini Ditujukan untuk tugas Mata Kuliah WEB II tahun ajaran 2023 (Kautsar). Aplikasi ini memiliki 3 Role user yaitu Administrator, Petugas, & Siswa.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
    <section class="d-flex justify-content-center align-items-center login-page" style="background-color: #eee;">
        <div class="card rounded-3 text-black container mb-0" style="max-width: 860px;">
            <div class="row g-0">
                <div class="col-lg-6">
                    <div class="card-body p-md-3 mx-md-4">

                        <div class="text-center">
                            <img src="{{ asset('assets/img/logo.png') }}" style="width: 100px;" alt="logo">
                            <h4 class="mt-1 mb-5 pb-1" style="font-size: 25px;">Aplikasi Pembayaran SPP SMA N 5 Kota Jambi</h4>
                        </div>

                        <form method="post" class="login100-form validate-form" action="{{ route('proses_login') }}">
                            @csrf

                            {{-- @error('login_gagal')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror --}}

                            <p>Please login to your account</p>

                            <div class="form-outline mb-4">
                                <label class="form-label" for="username">Username</label>
                                <input type="text" id="username" class="form-control"
                                    placeholder="Username" name="username" required />
                                <p class="mt-1 text-muted" style="font-size: 10px;">Note: <em>Untuk siswa masukan username dengan NISN!</em></p>
                            </div>

                            <div class="form-outline mb-4">
                                <label class="form-label" for="password">Password</label>
                                <input type="password" id="password" class="form-control"
                                    placeholder="Password" name="password" required />
                            </div>

                            <div class="text-center pt-1 mb-5 pb-1">
                                <button class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3"
                                    type="submit">Log
                                    in</button>
                            </div>

                        </form>

                    </div>
                </div>
                <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
                    <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                        <h4 class="mb-4">Aplikasi Pembayaran SPP</h4>
                        <p class="small mb-0">Aplikasi ini Ditujukan untuk tugas Mata Kuliah WEB II tahun ajaran 2023 -Kautsar-. Aplikasi ini memiliki 3 Role user yaitu Administrator, Petugas & Siswa.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
