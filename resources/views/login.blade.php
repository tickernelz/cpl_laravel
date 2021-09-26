@extends('layouts.simple')

@section('title')
Login
@endsection

@section('content')
<div class="bg-image" style="background-image: url({{ asset('media/photos/photo22@2x.jpg') }});">
    <div class="row g-0 bg-primary-op">
        <!-- Main Section -->
        <div class="hero-static col-md-6 d-flex align-items-center bg-body-extra-light">
            <div class="p-3 w-100">
                <!-- Header -->
                <div class="mb-3 text-center">
                    <a class="link-fx fw-bold fs-1" href="index.html">
                        <span class="text-dark">SI</span><span class="text-primary">CPL</span>
                    </a>
                    <p class="text-uppercase fw-bold fs-sm text-muted">Sign In</p>
                </div>
                <!-- END Header -->

                <!-- Sign In Form -->
                <div class="row g-0 justify-content-center">
                    <div class="col-sm-8 col-xl-6">
                        <form action="{{ route('login') }}" method="post">
                            @csrf
                            @if(session('errors'))
                            <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                <strong>Aduh!</strong> Ada yang error nih :
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            @if (Session::has('success'))
                            <div class="alert alert-success mb-3" role="alert">
                                {{ Session::get('success') }}
                            </div>
                            @endif
                            @if (Session::has('error'))
                            <div class="alert alert-danger mb-3" role="alert">
                                {{ Session::get('error') }}
                            </div>
                            @endif
                            <div class="py-3">
                                <div class="mb-4">
                                    <input type="text" class="form-control form-control-lg form-control-alt" id="username" name="username"
                                        placeholder="Masukkan username">
                                </div>
                                <div class="mb-4">
                                    <input type="password" class="form-control form-control-lg form-control-alt" id="password" name="password"
                                        placeholder="Masukkan password">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <div class="col-sm-6">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="remember" {{ old('remember') ? 'checked' : '' }} id="remember">
                                        <label class="form-check-label" for="remember">Ingat Saya</label>
                                    </div>
                                </div>
                                <div class="col-sm-6 text-end">
                                    <button class="btn btn-primary w-md btn-hero" type="submit"><i class="fa fa-fw fa-sign-in-alt opacity-50 me-1"></i> Masuk</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- END Sign In Form -->
            </div>
        </div>
        <!-- END Main Section -->

        <!-- Meta Info Section -->
        <div
            class="hero-static col-md-6 d-none d-md-flex align-items-md-center justify-content-md-center text-md-center">
            <div class="p-3">
                <p class="display-4 fw-bold text-white mb-3">
                    Sistem Informasi CPL
                </p>
                <p class="fs-lg fw-semibold text-white-75 mb-0">
                    Copyright &copy; <span data-toggle="year-copy"></span> TI UPR
                </p>
            </div>
        </div>
        <!-- END Meta Info Section -->
    </div>
</div>
@endsection
