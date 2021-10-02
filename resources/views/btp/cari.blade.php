@extends('layouts.backend')

@section('title')
    {{ $judul }}
@endsection

@section('css_before')
    <!-- Page JS Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/datatables-buttons-bs5/css/buttons.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/select2/css/select2.min.css') }}">
    <style>
        .select2-container {
            display: block;
        }
    </style>
@endsection

@section('js_after')
    <script src="{{ asset('js/lib/jquery.min.js') }}"></script>
    <script src="{{ asset('js/plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- Page JS Plugins -->
    <script src="{{ asset('js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons-bs5/js/buttons.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons-jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons-pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons-pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons/buttons.print.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons/buttons.html5.min.js') }}"></script>
    <script src="//cdn.datatables.net/plug-ins/1.11.3/sorting/natural.js"></script>

    <!-- Page JS Code -->
    <script src="{{ asset('js/pages/tables_datatables.js') }}"></script>
    <script>Dashmix.helpersOnLoad(['jq-select2']);</script>
    <script>
        $('#cpmk').select2({
            dropdownParent: $('#tambahbobot')
        });
        $('#kategori').select2({
            dropdownParent: $('#tambahbobot')
        });
        $('#dosen').select2({
            dropdownParent: $('#tambahbobot')
        });
        $('#cpmk1').select2({
            dropdownParent: $('#editbobot')
        });
        $('#kategori1').select2({
            dropdownParent: $('#editbobot')
        });
        $('#dosen1').select2({
            dropdownParent: $('#editbobot')
        });
    </script>
    <script type="text/javascript">
        function tambahFunc() {
            $.ajax({
                type: "POST",
                url: "{{ URL::to('tambah-btp') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    id_ta: '{{ Crypt::decrypt(Request::get('tahunajaran')) }}',
                    id_mk: '{{ Crypt::decrypt(Request::get('mk')) }}',
                    id_kelas: '{{ Crypt::decrypt(Request::get('kelas')) }}',
                    id_cpmk: $('#cpmk').val(),
                    id_dosen: $('#dosen').val(),
                    teknik: $('#teknik').val(),
                    semester: '{{ Crypt::decrypt(Request::get('semester')) }}',
                    kategori: $('#kategori').val(),
                    bobot: $('#bobot').val()
                },
                dataType: 'json',
                success: function (res) {
                    $("#tambahbobot").modal('hide');
                    location.reload();
                },
                error: function (data) {
                    alert('Gagal Input! Cek Total Bobot dan Pastikan Inputan Terisi Semua')
                    console.log(data);
                }
            });
        }

        function simpaneditFunc() {
            $.ajax({
                type: "POST",
                url: "{{ URL::to('edit-btp') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: $('#id1').val(),
                    id_ta: '{{ Crypt::decrypt(Request::get('tahunajaran')) }}',
                    id_mk: '{{ Crypt::decrypt(Request::get('mk')) }}',
                    id_kelas: '{{ Crypt::decrypt(Request::get('kelas')) }}',
                    id_cpmk: $('#cpmk1').val(),
                    id_dosen: $('#dosen1').val(),
                    teknik: $('#teknik1').val(),
                    semester: '{{ Crypt::decrypt(Request::get('semester')) }}',
                    kategori: $('#kategori1').val(),
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
                url: "{{ URL::to('get-btp') }}",
                dataType: "JSON",
                data: {id: id},
                success: function (data) {
                    $.map(data, function (obj) {
                        $('#editbobot').modal('show');
                        $('[name="id1"]').val(obj.id);
                        $('[name="cpmk1"]').val(obj.cpmk_id).trigger('change');
                        $('[name="teknik1"]').val(obj.nama);
                        $('[name="kategori1"]').val(obj.kategori).trigger('change');
                        $('[name="dosen1"]').val(obj.dosen_admin_id).trigger('change');
                        $('[name="bobot1"]').val(obj.bobot);
                    });
                }
            });
            return false;
        }

        function hapusFunc(id) {
            if (confirm("Hapus Bobot?") === true) {
                $.ajax({
                    type: "POST",
                    url: "{{ url('hapus-btp') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: id
                    },
                    dataType: 'json',
                    success: function (res) {
                        location.reload();
                    },
                    error: function (data) {
                        alert("Data yang ingin dihapus masih digunakan!")
                        console.log(data);
                    }
                });
            }
        }
    </script>
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
        <!-- Cari Data -->
        <div class="row">
            <div class="col-md-6 " style="float:none;margin:auto;">
                <form method="GET" action="{{URL::to('btp/cari')}}">
                    <div class="block block-rounded block-fx-shadow">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">{{ $judulform }}</h3>
                            <div class="block-options">
                                <button type="submit" class="btn btn-sm btn-outline-primary">
                                    <i class="fa fa-fw fa-search"></i> Cari
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
                                        <label class="form-label" for="tahunajaran">Tahun Ajaran</label>
                                        <select class="js-select2 form-select" name="tahunajaran" id="tahunajaran">
                                            @foreach($ta as $t)
                                                <option
                                                    value="{{ Crypt::encrypt($t->id) }}"
                                                    @if (Crypt::decrypt(Request::get('tahunajaran')) === $t->id)
                                                    selected="selected"
                                                    @endif>{{$t->tahun}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label" for="semester">Semester</label>
                                        <select class="js-select2 form-select" name="semester" id="semester">
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
                                    <div class="mb-4">
                                        <label class="form-label" for="mk">Mata Kuliah</label>
                                        <select class="js-select2 form-select" name="mk" id="mk">
                                            @foreach($mk as $m)
                                                <option
                                                    value="{{ Crypt::encrypt($m->id) }}"
                                                    @if (Crypt::decrypt(Request::get('mk')) === $m->id)
                                                    selected="selected"
                                                    @endif>{{$m->nama}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label">Ruang/Kelas</label>
                                        <div class="space-x-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="kelas1" name="kelas"
                                                       value="{{ Crypt::encrypt('A') }}"
                                                       @if (Crypt::decrypt(Request::get('kelas')) === 'A')
                                                       checked="" @endif>
                                                <label class="form-check-label" for="kelas1">Kelas A</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="kelas2" name="kelas"
                                                       value="{{ Crypt::encrypt('B') }}"
                                                       @if (Crypt::decrypt(Request::get('kelas')) === 'B')
                                                       checked="" @endif>
                                                <label class="form-check-label" for="kelas2">Kelas B</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="kelas3" name="kelas"
                                                       value="{{ Crypt::encrypt('C') }}"
                                                       @if (Crypt::decrypt(Request::get('kelas')) === 'C')
                                                       checked="" @endif>
                                                <label class="form-check-label" for="kelas3">Kelas C</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- END Cari Data -->

        <!-- Modal Tambah -->
        <div class="modal fade" id="tambahbobot" tabindex="-1" role="dialog" aria-labelledby="tambahkrs"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="block block-rounded block-themed block-transparent mb-0">
                        <div class="block-header bg-primary-dark">
                            <h3 class="block-title">Tambah {{$parent}}</h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-bs-dismiss="modal"
                                        aria-label="Close">
                                    <i class="fa fa-fw fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content">
                            <div class="mb-3">
                                <label class="form-label" for="cpmk">Kode CPMK</label>
                                <select class="js-select2 form-select" name="cpmk"
                                        id="cpmk">
                                    @foreach($cpmk_mk as $d)
                                        <option
                                            value="{{ $d->id }}">{{$d->kode_cpmk}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="teknik">Teknik Penilaian</label>
                                <input type="text" name="teknik" id="teknik"
                                       class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="kategori">Kategori</label>
                                <select class="js-select2 form-select" name="kategori"
                                        id="kategori">
                                    <option value="1">Tugas</option>
                                    <option value="2">UTS</option>
                                    <option value="3">UAS</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="dosen">Dosen</label>
                                <select class="js-select2 form-select" name="dosen"
                                        id="dosen">
                                    @foreach($da as $d)
                                        <option
                                            value="{{ $d->id }}">{{$d->nama}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="bobot">Bobot</label>
                                <input type="number" name="bobot" id="bobot"
                                       class="form-control" required>
                            </div>
                        </div>
                        <div class="block-content block-content-full text-end bg-body">
                            <button type="button" class="btn btn-sm btn-alt-secondary" data-bs-dismiss="modal">Tutup
                            </button>
                            <button type="button" id="btn-submit" onclick="tambahFunc()"
                                    class="btn btn-primary">
                                Simpan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Modal Tambah -->

        <!-- Modal Edit -->
        <div class="modal fade" id="editbobot" tabindex="-1" role="dialog"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="block block-rounded block-themed block-transparent mb-0">
                        <div class="block-header bg-primary-dark">
                            <h3 class="block-title">Edit {{$parent}}</h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-bs-dismiss="modal"
                                        aria-label="Close">
                                    <i class="fa fa-fw fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content">
                            <div class="mb-3">
                                <label class="form-label" for="id1">ID</label>
                                <input type="text" name="id1" id="id1"
                                       class="form-control" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="cpmk1">Kode CPMK</label>
                                <select class="js-select2 form-select" name="cpmk1"
                                        id="cpmk1">
                                    @foreach($cpmk_mk as $d)
                                        <option
                                            value="{{ $d->id }}">{{$d->kode_cpmk}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="teknik1">Teknik Penilaian</label>
                                <input type="text" name="teknik1" id="teknik1"
                                       class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="kategori1">Kategori</label>
                                <select class="js-select2 form-select" name="kategori1"
                                        id="kategori1">
                                    <option value="1">Tugas</option>
                                    <option value="2">UTS</option>
                                    <option value="3">UAS</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="dosen1">Dosen</label>
                                <select class="js-select2 form-select" name="dosen1"
                                        id="dosen1">
                                    @foreach($da as $d)
                                        <option
                                            value="{{ $d->id }}">{{$d->nama}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="bobot1">Bobot</label>
                                <input type="number" name="bobot1" id="bobot1"
                                       class="form-control" required>
                            </div>
                        </div>
                        <div class="block-content block-content-full text-end bg-body">
                            <button type="button" class="btn btn-sm btn-alt-secondary" data-bs-dismiss="modal">Tutup
                            </button>
                            <button type="button" id="btn-submit" onclick="simpaneditFunc()"
                                    class="btn btn-primary">
                                Simpan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Modal Edit -->

        <!-- Dynamic Table with Export Buttons -->
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">{{$parent}} <small>List</small></h3>
                <div class="block-options">
                    <div class="block-options-item">
                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                data-bs-target="#tambahbobot">Tambah
                        </button>
                    </div>
                </div>
            </div>
            <div class="block-content block-content-full">
                <div class="d-flex flex-row-reverse">
                    <div class="col-lg-4">
                        @if ($total_bobot < 99.9)
                            <div class="alert alert-warning py-2 mb-0" role="alert">
                                <strong>Waduh!</strong> Total Bobot Masih {{round($total_bobot, 2)}} nih,
                                <strong>Tambah</strong> {{ round((100-$total_bobot), 2) }}
                                Lagi.
                            </div>
                        @elseif($total_bobot >= 99.9 && $total_bobot <= 100.1)
                            <div class="alert alert-success py-2 mb-0" role="alert">
                                <strong>Kerja Bagus!</strong> Total Bobot Sudah Mencapai {{round($total_bobot, 2)}}.
                            </div>
                        @endif
                        @if (Session::has('error'))
                            <div class="alert alert-danger py-2 mb-0" role="alert">
                                {{ Session::get('error') }}
                            </div>
                        @endif
                    </div>
                </div>
                <!-- DataTables init on table by adding .js-dataTable-buttons class, functionality is initialized in js/pages/tables_datatables.js -->
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-vcenter js-dataTable-buttons">
                        <thead>
                        <tr>
                            <th class="text-center" style="width: 80px;">#</th>
                            <th>Kode CPMK</th>
                            <th>Dosen</th>
                            <th>Nama Teknik Penilaian</th>
                            <th>Kategori</th>
                            <th>Bobot</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $li)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $li->cpmk->kode_cpmk }}</td>
                                <td>{{ $li->dosen_admin->nama }}</td>
                                <td>{{ $li->nama }}</td>
                                @if ($li->kategori === 1)
                                    <td>Tugas</td>
                                @elseif($li->kategori === 2)
                                    <td>UTS</td>
                                @elseif($li->kategori === 3)
                                    <td>UAS</td>
                                @endif
                                <td>{{ $li->bobot }}</td>
                                <td class="text-center" style="width: 100px">
                                    <div class="btn-group">
                                        <a href="javascript:void(0)"
                                           class="btn btn-secondary btn-sm edit"
                                           onclick="editFunc({{ $li->id }})" title="Edit">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <a href="javascript:void(0)"
                                           class="btn btn-secondary btn-sm edit"
                                           onclick="hapusFunc({{ $li->id }})" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- END Dynamic Table with Export Buttons -->
    </div>
    <!-- END Page Content -->
@endsection
