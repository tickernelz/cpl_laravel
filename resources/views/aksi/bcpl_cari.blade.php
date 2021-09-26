@extends('layouts.main')

@section('title')
    {{'Kelola Bobot CPL'}}
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
                                        <form method="get" action="{{URL::to('bcpl/cari')}}">
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
                                                <label class="form-label">Mata Kuliah</label>
                                                <select class="form-select" name="mk" id="mk">
                                                    @foreach($mk as $m)
                                                        <option
                                                            value="{{ Crypt::encrypt($m->id) }}"
                                                            @if (Crypt::decrypt(Request::get('mk')) === $m->id)
                                                            selected="selected"
                                                            @endif>{{$m->nama}}</option>
                                                    @endforeach
                                                </select>
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
                                                data-bs-target="#tambahbobot">Tambah
                                            Bobot
                                        </button>
                                        @if ($total_bobot < 99.8)
                                            <div class="alert alert-warning" role="alert">
                                                <strong>Waduh!</strong> Total Bobot Masih {{$total_bobot}} nih, <strong>Tambah</strong> {{ 100-$total_bobot }}
                                                Lagi.
                                            </div>
                                        @elseif($total_bobot >= 99.8 && $total_bobot <= 101.00)
                                            <div class="alert alert-success" role="alert">
                                                <strong>Kerja Bagus!</strong> Total Bobot Sudah Mencapai 100.
                                            </div>
                                        @endif
                                        @if (Session::has('error'))
                                            <div class="alert alert-danger" role="alert">
                                                {{ Session::get('error') }}
                                            </div>
                                        @endif
                                        <div class="modal fade" id="tambahbobot" tabindex="-1" role="dialog"
                                             aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-scrollable">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="tambahbobotTitle">
                                                            Tambah Bobot CPL</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label class="form-label">Kode CPMK</label>
                                                            <select class="form-select" name="cpmk"
                                                                    id="cpmk" onclick="cekTeknik()">
                                                                @foreach($cpmk_mk as $d)
                                                                    <option
                                                                        value="{{ $d->id }}">{{$d->kode_cpmk}}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Kode CPL</label>
                                                            <select class="form-select" name="cpl"
                                                                    id="cpl">
                                                                @foreach($cpl as $d)
                                                                    <option
                                                                        value="{{ $d->id }}">{{$d->kode_cpl}}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Nama Teknik</label>
                                                            <select class="form-select" name="btp"
                                                                    id="btp">
                                                                <option value="">-- Pilih Kode CPMK Terlebih Dahulu --
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Bobot</label>
                                                            <input type="number" name="bobot" id="bobot"
                                                                   class="form-control" required>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Tutup
                                                        </button>
                                                        <button type="button" id="btn-submit" onclick="tambahFunc()"
                                                                class="btn btn-primary">
                                                            Simpan
                                                        </button>
                                                    </div>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                        <div class="modal fade" id="editbobot" tabindex="-1" role="dialog"
                                             aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-scrollable">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editbobotTitle">
                                                            Edit Bobot CPL</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label class="form-label">ID</label>
                                                            <input type="text" name="id1" id="id1"
                                                                   class="form-control" readonly>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Kode CPMK</label>
                                                            <select class="form-select" name="cpmk1"
                                                                    id="cpmk1" onclick="cekTeknik2()">
                                                                @foreach($cpmk_mk as $d)
                                                                    <option
                                                                        value="{{ $d->id }}">{{$d->kode_cpmk}}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Kode CPL</label>
                                                            <select class="form-select" name="cpl1"
                                                                    id="cpl1">
                                                                @foreach($cpl as $d)
                                                                    <option
                                                                        value="{{ $d->id }}">{{$d->kode_cpl}}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Nama Teknik</label>
                                                            <select class="form-select" name="btp1"
                                                                    id="btp1">
                                                                <option value="">-- Pilih Kode CPMK Terlebih Dahulu --
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Bobot</label>
                                                            <input type="number" name="bobot1" id="bobot1"
                                                                   class="form-control" required>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Tutup
                                                        </button>
                                                        <button type="button" id="btn-submit" onclick="simpaneditFunc()"
                                                                class="btn btn-primary">
                                                            Simpan
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
                                            <table id="datatable1" class="table table-hover table-bordered">
                                                <thead>
                                                <tr>
                                                    <th>Nomor</th>
                                                    <th>Kode CPMK</th>
                                                    <th>Kode CPL</th>
                                                    <th>Nama Teknik</th>
                                                    <th>Bobot</th>
                                                    <th class="text-center">Aksi</th>
                                                </tr>
                                                </thead>

                                                <tbody>
                                                @foreach($data as $li)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $li->cpmk->kode_cpmk }}</td>
                                                        <td>{{ $li->cpl->kode_cpl }}</td>
                                                        <td>{{ $li->btp->nama }}</td>
                                                        <td>{{ $li->bobot_cpl }}</td>
                                                        <td class="text-center" style="width: 100px">
                                                            <a href="javascript:void(0)"
                                                               class="btn btn-secondary btn-sm edit"
                                                               onclick="editFunc({{ $li->id }})" title="Delete">
                                                                <i class="fas fa-pencil-alt"></i>
                                                            </a>
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
                <script type="text/javascript">
                    function cekTeknik() {
                        $.ajax({
                            url: "{{ URL::to('cek-teknik') }}",
                            data: {
                                id_ta: '{{ Request::get('tahunajaran') }}',
                                id_mk: '{{ Request::get('mk') }}',
                                semester: '{{ Request::get('semester') }}',
                                cpmk: $("#cpmk").val()
                            },
                            type: "GET",
                            success: function (data) {
                                $('#btp option:gt(0)').remove();
                                $.each(data, function (i, item) {
                                    $('#btp').append($('<option>', {
                                        value: item.id,
                                        text: item.nama
                                    }));
                                });
                            },
                            error: function () {
                            }
                        });
                    }

                    function cekTeknik2() {
                        $.ajax({
                            url: "{{ URL::to('cek-teknik') }}",
                            data: {
                                id_ta: '{{ Request::get('tahunajaran') }}',
                                id_mk: '{{ Request::get('mk') }}',
                                semester: '{{ Request::get('semester') }}',
                                cpmk: $("#cpmk1").val()
                            },
                            type: "GET",
                            success: function (data) {
                                $('#btp1 option:gt(0)').remove();
                                $.each(data, function (i, item) {
                                    $('#btp1').append($('<option>', {
                                        value: item.id,
                                        text: item.nama
                                    }));
                                });
                            },
                            error: function () {
                            }
                        });
                    }

                    function tambahFunc() {
                        $.ajax({
                            type: "POST",
                            url: "{{ URL::to('tambah-bcpl') }}",
                            data: {
                                _token: "{{ csrf_token() }}",
                                id_ta: '{{ Crypt::decrypt(Request::get('tahunajaran')) }}',
                                id_mk: '{{ Crypt::decrypt(Request::get('mk')) }}',
                                id_cpmk: $('#cpmk').val(),
                                id_cpl: $('#cpl').val(),
                                id_btp: $('#btp').val(),
                                semester: '{{ Crypt::decrypt(Request::get('semester')) }}',
                                bobot: $('#bobot').val()
                            },
                            dataType: 'json',
                            success: function (res) {
                                $("#tambahbobot").modal('hide');
                                location.reload();
                            },
                            error: function (data) {
                                alert('Gagal Input! Cek Total Bobot dan Pastikan Inputan Terisi Semua')
                                $("#cpmk").val('')
                                $("#cpl").val('')
                                $("#btp").val('')
                                $("#bobot").val('')
                                console.log(data);
                            }
                        });
                    }

                    function simpaneditFunc() {
                        $.ajax({
                            type: "POST",
                            url: "{{ URL::to('edit-bcpl') }}",
                            data: {
                                _token: "{{ csrf_token() }}",
                                id: $('#id1').val(),
                                id_ta: '{{ Crypt::decrypt(Request::get('tahunajaran')) }}',
                                id_mk: '{{ Crypt::decrypt(Request::get('mk')) }}',
                                id_cpmk: $('#cpmk1').val(),
                                id_cpl: $('#cpl1').val(),
                                id_btp: $('#btp1').val(),
                                semester: '{{ Crypt::decrypt(Request::get('semester')) }}',
                                bobot: $('#bobot1').val()
                            },
                            dataType: 'json',
                            success: function (res) {
                                $("#editbobot").modal('hide');
                                location.reload();
                            },
                            error: function (data) {
                                alert('Gagal Input! Cek Total Bobot dan Pastikan Inputan Terisi Semua')
                                console.log(data);
                            }
                        });
                    }

                    function editFunc(id) {
                        $.ajax({
                            type: "GET",
                            url: "{{ URL::to('get-bcpl') }}",
                            dataType: "JSON",
                            data: {id: id},
                            success: function (data) {
                                $.map(data, function (obj) {
                                    $('#editbobot').modal('show');
                                    $('[name="id1"]').val(obj.id);
                                    $('[name="cpmk1"]').val(obj.cpmk_id);
                                    $('[name="cpl1"]').val(obj.cpl_id);
                                    $('[name="bobot1"]').val(obj.bobot_cpl);
                                });
                            }
                        });
                        return false;
                    }

                    function hapusFunc(id) {
                        if (confirm("Hapus Bobot?") === true) {
                            $.ajax({
                                type: "POST",
                                url: "{{ url('hapus-bcpl') }}",
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
