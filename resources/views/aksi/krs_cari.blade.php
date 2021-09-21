@extends('layouts.main')

@section('title')
    {{'Kelola KRS'}} ({{ $nama_mhs  }})
@endsection

@section('head')
    <link href="{{asset('assets/css/custom.css')}}" rel="stylesheet" type="text/css">
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
                                            <div class="mb-3">
                                                <label class="form-label">Tahun Ajaran</label>
                                                <select class="form-select" name="tahunajaran" id="tahunajaran">
                                                    @foreach($ta as $t)
                                                        <option
                                                            value="{{ Crypt::encrypt($t->id) }}"
                                                            @if (Crypt::decrypt(Request::get('tahunajaran')) === $t->id)
                                                            selected="selected"
                                                            @endif>{{$t->tahun}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Semester</label>
                                                <select class="form-select" name="semester" id="semester">

                                                    <option value="{{ Crypt::encrypt('1') }}"
                                                            @if (Crypt::decrypt(Request::get('semester')) === '1')
                                                            selected="selected"
                                                        @endif>Ganjil
                                                    </option>
                                                    <option value="{{ Crypt::encrypt('2') }}"
                                                            @if (Crypt::decrypt(Request::get('semester')) === '2')
                                                            selected="selected"
                                                        @endif>Genap
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">NIM</label>
                                                <input type="text" name="nim" id="nim"
                                                       class="form-control" value="{{ Request::get('nim') }}" required>
                                            </div>
                                            <button type="submit" id="btn-cari"
                                                    class="btn btn-primary btn-lg w-100 waves-effect waves-light">
                                                Cari
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <button type="button"
                                                class="btn btn-primary btn-lg waves-effect waves-light mb-4"
                                                data-bs-toggle="modal"
                                                data-bs-target="#tambahkrs">Tambah
                                            KRS
                                        </button>
                                        <div class="modal fade" id="tambahkrs" tabindex="-1" role="dialog"
                                             aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-scrollable modal-xl">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="tambahkrsTitle">
                                                            Pilih Mata Kuliah</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="table-rep-plugin">
                                                            <div class="table-responsive mb-0"
                                                                 data-bs-pattern="priority-columns">
                                                                <table id="datatable2" class="table table-striped">
                                                                    <thead>
                                                                    <tr>
                                                                        <th>Kode Mata Kuliah</th>
                                                                        <th>Nama Mata Kuliah</th>
                                                                        <th class="text-center">Aksi</th>
                                                                    </tr>
                                                                    </thead>

                                                                    <tbody>
                                                                    @if(isset($dataselain))
                                                                        @foreach($dataselain as $ds)
                                                                            <tr>
                                                                                <td>{{ $ds->kode }}</td>
                                                                                <td>{{ $ds->nama }}</td>
                                                                                <td class="text-center"
                                                                                    style="width: 100px">
                                                                                    <a href="javascript:void(0)"
                                                                                       onclick="tambahFunc({{ $ds->id }})"
                                                                                       data-original-title="Tambah"
                                                                                       class="btn btn-secondary btn-sm edit"
                                                                                       title="Tambah">
                                                                                        <i class="fas fa-plus-square"></i>
                                                                                    </a>
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    @else
                                                                    @endif
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Tutup
                                                        </button>
                                                    </div>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                    </div>
                                    <div class="table-rep-plugin">
                                        <div class="table-responsive mb-0" data-bs-pattern="priority-columns">
                                            <table id="datatable1" class="table table-striped">
                                                <thead>
                                                <tr>
                                                    <th>Nomor</th>
                                                    <th>Kode Mata Kuliah</th>
                                                    <th>Nama Mata Kuliah</th>
                                                    <th class="text-center">Aksi</th>
                                                </tr>
                                                </thead>

                                                <tbody>
                                                @foreach($data as $li)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $li->mata_kuliah->kode }}</td>
                                                        <td>{{ $li->mata_kuliah->nama }}</td>
                                                        <td class="text-center" style="width: 100px">
                                                            <a href="javascript:void(0)"
                                                               class="btn btn-secondary btn-sm edit"
                                                               onclick="hapusFunc({{ $li->id }})" title="Delete">
                                                                <i class="fas fa-trash"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                            </div> <!-- end row -->
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
                <script src="{{ asset('assets/js/auto.js') }}"></script>
                <script type="text/javascript">
                    $.ajaxSetup({headers: {'csrftoken': '{{ csrf_token() }}'}});

                    function tambahFunc(id) {
                        $.ajax({
                            type: "POST",
                            url: "{{ URL::to('tambah-krs') }}",
                            data: {
                                _token: "{{ csrf_token() }}",
                                id_mk: id,
                                id_mhs: '{{ Request::get('nim') }}',
                                id_ta: {{ Crypt::decrypt(Request::get('tahunajaran')) }},
                                sem: {{Crypt::decrypt(Request::get('semester'))}}
                            },
                            dataType: 'json',
                            success: function (res) {
                                $("#tambahkrs").modal('hide');
                                location.reload();
                            },
                            error: function (data) {
                                alert('Gagal Input!')
                                console.log(data);
                            }
                        });
                    }

                    function hapusFunc(id) {
                        if (confirm("Hapus Mata Kuliah?") === true) {
                            $.ajax({
                                type: "POST",
                                url: "{{ url('hapus-krs') }}",
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    id: id
                                },
                                dataType: 'json',
                                success: function (res) {
                                    location.reload();
                                },
                                error: function (data) {
                                    console.log(data);
                                }
                            });
                        }
                    }
                </script>
@endsection
