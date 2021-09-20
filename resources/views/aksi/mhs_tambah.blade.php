@extends('layouts.main')

@section('title')
    {{'Tambah Mahasiswa'}}
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
                                            <label class="form-label">NIM</label>
                                            <input type="text" id="nim" name="nim" class="form-control"
                                                   value="{{ old('nim') }}" onkeyup="checkAvailability3()"
                                                   required placeholder="Nomor Induk Mahasiswa">
                                            <span id="3-availability-status"></span>
                                            <p><img src="{{asset('assets/images/LoaderIcon.gif')}}" id="loaderIcon3"
                                                    style="display:none"/></p>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Nama Lengkap</label>
                                            <input type="text" name="nama" value="{{ old('nama') }}"
                                                   class="form-control" required>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Angkatan</label>
                                            <select class="form-select" name="angkatan" aria-label="Angkatan Mahasiswa">
                                                <?php
                                                for ($year = (int)date('Y'); 1900 <= $year; $year--): ?>
                                                <option value="<?= $year + 3?>"><?= $year + 3?></option>
                                                <?php endfor; ?>
                                            </select>
                                        </div>

                                        <div class="mb-0">
                                            <div>
                                                <button type="submit" name="simpan" id="simpan"
                                                        class="btn btn-primary waves-effect waves-light me-1" disabled>
                                                    Simpan
                                                </button>
                                                <button type="button" class="btn btn-secondary waves-effect"
                                                        onclick="window.location.href='{{ redirect()->getUrlGenerator()->route('mhs') }}'">
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
    <script type="text/javascript">
        function checkAvailability3() {
            $("#loaderIcon3").show();
            jQuery.ajax({
                url: "/cek",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "nim": $("#nim").val()
                },
                type: "POST",
                success: function (data) {
                    $("#3-availability-status").html(data);
                    $("#loaderIcon3").hide();
                    var status3 = document.getElementById("status-3");
                    var status3Class = status3.className;
                    if (status3Class === 'status-not-available') {
                        $('#simpan').attr('disabled', 'disabled');
                    } else if (status3Class === 'status-available') {
                        $('#simpan').removeAttr('disabled');
                    }
                },
                error: function () {
                }
            });
        }
    </script>
@endsection