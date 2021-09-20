@extends('layouts.main')

@section('title')
    {{'Kelola KRS'}}
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
                        <div class="col-12">
                            <div class="col-lg-6" style="float:none;margin:auto;">
                                <div class="card">
                                    <div class="card-body">
                                        <form method="get" action="{{URL::to('krs/cari')}}">
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
                                                <select class="form-select" name="tahunajaran" id="tahunajaran">
                                                    @foreach($ta as $t)
                                                        <option
                                                            value="{{ Crypt::encrypt($t->id) }}">{{$t->tahun}}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Semester</label>
                                                <select class="form-select" name="semester" id="semester">
                                                    <option value="{{ Crypt::encrypt('1') }}">Ganjil
                                                    </option>
                                                    <option value="{{ Crypt::encrypt('2') }}">Genap
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">NIM</label>
                                                <input type="text" name="nim" id="nim"
                                                       class="form-control" onkeyup="checkAvailability2()" required>
                                                <div id="nim_list"></div>
                                            </div>
                                            <button type="submit" id="btn-cari"
                                                    class="btn btn-primary btn-lg w-100 waves-effect waves-light">
                                                Cari
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- container-fluid -->
                    </div>
                    <!-- End Page-content -->
                    @include('partial.footer')
                </div>
                <!-- end main content-->
            </div>
            <!-- END layout-wrapper -->
            @endsection
            @section('js')
                <script type="text/javascript">
                    $(document).ready(function () {

                        $('#nim').on('keyup', function () {
                            var query = $(this).val();
                            $.ajax({
                                url: "{{ route('carinim') }}",
                                type: "GET",
                                data: {'nim': query},
                                success: function (data) {
                                    $('#nim_list').html(data);
                                }
                            })
                            // end of ajax call
                        });


                        $(document).on('click', 'li', function () {
                            var value = $(this).text();
                            $('#nim').val(value);
                            $('#nim_list').html("");
                        });
                    });
                </script>
@endsection