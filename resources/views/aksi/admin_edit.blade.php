@extends('layouts.main')

@section('title')
    {{'Edit Admin'}}
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
                                            <label class="form-label">NIP</label>
                                            <input type="text" id="nip" name="nip" class="form-control"
                                                   value="{{ $admin->nip }}" onkeyup="checkAvailability1()" required
                                                   placeholder="Nomor Induk Pegawai">

                                            <span id="1-availability-status"></span>
                                            <p><img src="{{asset('assets/images/LoaderIcon.gif')}}" id="loaderIcon1"
                                                    style="display:none"/></p>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Nama Lengkap</label>
                                            <input type="text" name="nama" value="{{ $admin->nama }}"
                                                   class="form-control" required>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Username</label>
                                            <input type="text" id="username" name="username"
                                                   value="{{ $admin->user->username }}" onkeyup="checkAvailability2()"
                                                   class="form-control" required>
                                            <span id="2-availability-status"></span>
                                            <p><img src="{{asset('assets/images/LoaderIcon.gif')}}" id="loaderIcon2"
                                                    style="display:none"/></p>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Password</label>
                                            <input type="password" name="password" value="{{ $admin->user->password }}"
                                                   class="form-control" required>
                                        </div>

                                        <div class="mb-0">
                                            <div>
                                                <button type="submit" name="simpan" id="simpan"
                                                        class="btn btn-primary waves-effect waves-light me-1">
                                                    Simpan
                                                </button>
                                                <button type="button" class="btn btn-secondary waves-effect"
                                                        onclick="window.location.href='{{ redirect()->getUrlGenerator()->route('admin') }}'">
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
        function checkAvailability1() {
            $("#loaderIcon1").show();
            jQuery.ajax({
                url: "/cek",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "nip": $("#nip").val()
                },
                type: "POST",
                success: function (data) {
                    $("#1-availability-status").html(data);
                    $("#loaderIcon1").hide();
                    var status1 = document.getElementById("status-1");
                    var status1Class = status1.className;
                    var status2 = document.getElementById("status-2");
                    var status2Class = status2.className;
                    if (status2Class === 'status-not-available' || status1Class === 'status-not-available') {
                        $('#simpan').attr('disabled', 'disabled');
                    } else if (status2Class === 'status-available' || status1Class === 'status-available') {
                        $('#simpan').removeAttr('disabled');
                    }
                },
                error: function () {
                }
            });
        }

        function checkAvailability2() {
            $("#loaderIcon2").show();
            jQuery.ajax({
                url: "/cek",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "username": $("#username").val()
                },
                type: "POST",
                success: function (data) {
                    $("#2-availability-status").html(data);
                    $("#loaderIcon2").hide();
                    var status1 = document.getElementById("status-1");
                    var status1Class = status1.className;
                    var status2 = document.getElementById("status-2");
                    var status2Class = status2.className;
                    if (status2Class === 'status-not-available' || status1Class === 'status-not-available') {
                        $('#simpan').attr('disabled', 'disabled');
                    } else if (status2Class === 'status-available' || status1Class === 'status-available') {
                        $('#simpan').removeAttr('disabled');
                    }
                },
                error: function () {
                }
            });
        }
    </script>
@endsection
