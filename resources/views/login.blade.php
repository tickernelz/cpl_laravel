@extends('layouts.main')

@section('title')
Login
@endsection

@section('container')
<div class="account-pages my-5 pt-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-4">
                <div class="card overflow-hidden">
                    <div class="bg-primary">
                        <div class="text-primary text-center p-4">
                            <h5 class="text-white font-size-20">Selamat Datang !</h5>
                            <a href="/" class="logo logo-admin">
                                <img src="{{asset('assets/images/logo-upr.png')}}" height="24" alt="logo">
                            </a>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <div class="p-3">
                            <form class="mt-4" action="{{ route('login') }}" method="post">
                                @csrf
                                @if(session('errors'))
                                <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
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
                                <div class="mb-3">
                                    <label class="form-label" for="username">Username</label>
                                    <input type="text" class="form-control" name="username" id="username"
                                        placeholder="Masukkan username">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="userpassword">Password</label>
                                    <input type="password" class="form-control" name="password" id="userpassword"
                                        placeholder="Masukkan password">
                                </div>

                                <div class="mb-3 row">
                                    <div class="col-sm-6">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" name="remember"
                                                {{ old('remember') ? 'checked' : '' }} id="remember">
                                            <label class="form-check-label" for="remember">Ingat Saya</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 text-end">
                                        <button class="btn btn-primary w-md waves-effect waves-light"
                                            type="submit">Masuk</button>
                                    </div>
                                </div>

                            </form>

                        </div>
                    </div>

                </div>

                <div class="mt-5 text-center">
                    <p class="mb-0">
                        ©
                        <script>
                            document.write(new Date().getFullYear())
                        </script>
                        TI UPR.
                    </p>
                </div>


            </div>
        </div>
    </div>
</div>
@endsection
