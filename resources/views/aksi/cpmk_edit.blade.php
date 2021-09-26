@extends('layouts.main')

@section('title')
    {{'Edit CPMK'}}
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
                                            <label class="form-label">Mata Kuliah</label>
                                            <select class="form-select" name="mata_kuliah" id="mata_kuliah"
                                                    onclick="checkAvailability3()">
                                                @foreach($mk as $t)
                                                    <option
                                                        value="{{ $t->id }}" @if ($t->id === $cpmk->mata_kuliah_id)
                                                    selected="selected"
                                                        @endif>{{$t->nama}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Kode CPMK</label>
                                            <input type="text" id="kode_cpmk" name="kode_cpmk" class="form-control"
                                                   value="{{ $cpmk->kode_cpmk }}" onkeyup="checkAvailability3()"
                                                   required placeholder="Kode">
                                            <span id="3-availability-status"></span>
                                            <p><img src="{{asset('assets/images/LoaderIcon.gif')}}" id="loaderIcon3"
                                                    style="display:none"/></p>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Nama CPMK</label>
                                            <input type="text" name="nama_cpmk" value="{{ $cpmk->nama_cpmk }}"
                                                   class="form-control" required placeholder="Nama">
                                        </div>

                                        <div class="mb-0">
                                            <div>
                                                <button type="submit" name="simpan" id="simpan"
                                                        class="btn btn-primary waves-effect waves-light me-1">
                                                    Simpan
                                                </button>
                                                <button type="button" class="btn btn-secondary waves-effect"
                                                        onclick="window.location.href='{{ redirect()->getUrlGenerator()->route('cpmk') }}'">
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
                    "kode_cpmk": $("#kode_cpmk").val(),
                    "mata_kuliah": $("#mata_kuliah").val(),
                },
                type: "POST",
                success: function (data) {
                    $("#3-availability-status").html(data);
                    $("#loaderIcon3").hide();
                    var status = document.getElementById("status-4");
                    var statusClass = status.className;
                    if (statusClass === 'status-not-available') {
                        $('#simpan').attr('disabled', 'disabled');
                    } else if (statusClass === 'status-available') {
                        $('#simpan').removeAttr('disabled');
                    }
                },
                error: function () {
                }
            });
        }
    </script>
@endsection
