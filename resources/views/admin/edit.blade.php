@extends('layouts.backend')

@section('title')
    {{ $judul }}
@endsection

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-grow-1 fs-3 fw-semibold my-2 my-sm-3">{{ $judul }}</h1>
                <nav class="flex-shrink-0 my-2 my-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">{{ $parent }}</li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $subparent }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- END Hero -->

    <!-- Page Content -->
    <div class="content">
        <!-- Your Block -->
        <div class="col-md-6 " style="float:none;margin:auto;">
            <form method="POST" action="{{url()->current()}}/post">
                <div class="block block-rounded">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Form Edit Admin</h3>
                        <div class="block-options">
                            <button type="submit" class="btn btn-sm btn-outline-primary">
                                <i class="fa fa-check"></i> Simpan
                            </button>
                            <button type="reset" class="btn btn-sm btn-outline-danger">Reset</button>
                            <button type="button" class="btn btn-sm btn-secondary"
                                    onclick="window.location.href='{{ redirect()->getUrlGenerator()->route('admin') }}'">
                                Kembali
                            </button>
                        </div>
                    </div>
                    <div class="block-content">
                        @csrf
                        @if(session('errors'))
                            <div class="alert alert-danger alert-dismissible fade show mb-3"
                                 role="alert">
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
                        <div class="row justify-content-center py-sm-3 py-md-5">
                            <div class="col-lg-10 col-lg-8">
                                <div class="mb-4">
                                    <label class="form-label" for="nip">NIP</label>
                                    <input name="nip-ori" type="hidden" value="{{ $admin->nip }}">
                                    <input type="text" class="form-control form-control-alt" id="nip"
                                           value="{{ $admin->nip }}" name="nip"
                                           placeholder="Masukkan NIP..." required>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label" for="nama">Nama Lengkap</label>
                                    <input type="text" class="form-control form-control-alt" id="nama"
                                           value="{{ $admin->nama }}" name="nama"
                                           placeholder="Masukkan Nama Lengkap..." required>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label" for="username">Username</label>
                                    <input name="username-ori" type="hidden" value="{{ $admin->user->username }}">
                                    <input type="text" class="form-control form-control-alt" id="username"
                                           value="{{ $admin->user->username }}"
                                           name="username"
                                           placeholder="Masukkan Username..." required>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label" for="password">Password</label>
                                    <input name="password-ori" type="hidden" value="{{ $admin->user->password }}">
                                    <input type="password" class="form-control form-control-alt" id="password"
                                           value="{{ $admin->user->password }}"
                                           name="password"
                                           placeholder="Masukkan Password..." required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- END Your Block -->
    </div>
    <!-- END Page Content -->
@endsection
