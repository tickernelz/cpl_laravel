@extends('layouts.main')

@section('title')
    {{'Edit Mahasiswa'}}
@endsection

@section('container')

    <div id="layout-wrapper">

        @include('partial.topbar')
        @include('partial.sidebar')

        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    @include('partial.pagetitle')

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">

                                    <form method="POST" class="custom-validation" action="{{url()->current()}}/post">
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
                                        <div class="mb-3">
                                            <label class="form-label">Tahun Ajaran</label>
                                            <select class="form-select" name="tahun" aria-label="Tahun Ajaran">
                                                <?php
                                                for ($year = (int)date('Y'); 2000 <= $year; $year--): ?>
                                                <option value="<?= $year + 3?>/<?= $year + 4?>"><?= $year + 3?>
                                                    /<?= $year + 4?></option>
                                                <?php endfor; ?>
                                            </select>
                                        </div>

                                        <div class="mb-0">
                                            <div>
                                                <button type="submit" name="simpan" id="simpan"
                                                        class="btn btn-primary waves-effect waves-light me-1">
                                                    Simpan
                                                </button>
                                                <button type="button" class="btn btn-secondary waves-effect"
                                                        onclick="window.location.href='{{ redirect()->getUrlGenerator()->route('ta') }}'">
                                                    Kembali
                                                </button>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div> <!-- end col -->

                    </div> <!-- end row -->
                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

        </div>

        @include('partial.footer')
    </div>
    <!-- end main content-->
@endsection
