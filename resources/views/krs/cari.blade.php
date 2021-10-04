@extends('layouts.backend')

@section('title')
    {{ $judul }}
@endsection

@section('css_before')
    <!-- Page JS Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/datatables-buttons-bs5/css/buttons.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/select2/css/select2.min.css') }}">
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
    <script type="text/javascript">
        function tambahFunc(id) {
            $.ajax({
                type: "POST",
                url: "{{ URL::to('tambah-krs') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    id_mk: id,
                    id_mhs: {{ Crypt::decrypt(Request::get('nim')) }},
                    id_ta: {{ Crypt::decrypt(Request::get('tahunajaran')) }},
                    sem: {{ Crypt::decrypt(Request::get('semester')) }},
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
        <!-- Cari Data KRS -->
        <div class="row">
            <div class="col-md-6 " style="float:none;margin:auto;">
                <form method="GET" action="{{URL::to('krs/cari')}}">
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
                                            @foreach($ta as $item)
                                                <option
                                                    value="{{ Crypt::encrypt($item->id) }}"
                                                    @if (Crypt::decrypt(Request::get('tahunajaran')) === $item->id)
                                                    selected="selected"
                                                    @endif>{{$item->tahun}}
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
                                        <label class="form-label" for="nim">Mahasiswa</label>
                                        <select class="js-select2 form-select" name="nim" id="nim">
                                            @foreach($mhs as $item)
                                                <option
                                                    value="{{ Crypt::encrypt($item->id) }}"
                                                    @if (Crypt::decrypt(Request::get('nim')) === $item->id)
                                                    selected="selected"
                                                    @endif>{{$item->nim}} ({{$item->nama}})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- END Cari Data KRS -->
        <!-- Modal Tambah KRS -->
        <div class="modal fade" id="tambahkrs" tabindex="-1" role="dialog" aria-labelledby="tambahkrs"
             aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="block block-rounded block-themed block-transparent mb-0">
                        <div class="block-header bg-primary-dark">
                            <h3 class="block-title">Pilih Mata Kuliah</h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-bs-dismiss="modal"
                                        aria-label="Close">
                                    <i class="fa fa-fw fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content">
                            <div class="table-rep-plugin">
                                <div class="table-responsive mb-0"
                                     data-bs-pattern="priority-columns">
                                    <table id="datatable2" class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th>Kode Mata Kuliah</th>
                                            <th>Nama Mata Kuliah</th>
                                            <th class="text-center">SKS</th>
                                            <th class="text-center">Semester</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        @if(isset($dataselain))
                                            @foreach($dataselain as $ds)
                                                <tr>
                                                    <td>{{ $ds->kode }}</td>
                                                    <td>{{ $ds->nama }}</td>
                                                    <td class="text-center">{{ $ds->sks }}</td>
                                                    <td class="text-center">{{ $ds->semester }}</td>
                                                    <td class="text-center"
                                                        style="width: 100px">
                                                        <a href="javascript:void(0)"
                                                           onclick="tambahFunc({{ $ds->id }})"
                                                           data-original-title="Tambah"
                                                           class="btn btn-outline-primary btn-sm edit"
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
                        <div class="block-content block-content-full text-end bg-body">
                            <button type="button" class="btn btn-sm btn-alt-secondary" data-bs-dismiss="modal">Tutup
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Modal Tambah KRS -->
        <!-- Dynamic Table with Export Buttons -->
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">KRS ({{ $nama_mhs }}) <small>List</small></h3>
                <div class="block-options">
                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                            data-bs-target="#tambahkrs">Tambah
                    </button>
                </div>
            </div>
            <div class="block-content block-content-full">
                <div class="d-flex flex-row-reverse">
                    <div class="col-lg-3">
                        @if ($sum_sks > 24)
                            <div class="alert alert-warning py-2 mb-0" role="alert">
                                <strong>Waduh!</strong> Total SKS Melebihi <strong>{{$sum_sks}}</strong> nih
                            </div>
                        @elseif($sum_sks >= 1)
                            <div class="alert alert-success py-2 mb-0" role="alert">
                               Total <strong>SKS </strong>Adalah <strong>{{$sum_sks}}</strong>
                            </div>
                        @else
                            <div class="alert alert-danger py-2 mb-0" role="alert">
                                <strong>Loh!</strong> Total SKS Masih <strong>{{$sum_sks}}</strong> Nih!
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
                            <th>Kode Mata Kuliah</th>
                            <th>Nama Mata Kuliah</th>
                            <th class="text-center">SKS</th>
                            <th class="text-center">Semester Mata Kuliah</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $li)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $li->mata_kuliah->kode }}</td>
                                <td>{{ $li->mata_kuliah->nama }}</td>
                                <td class="text-center">{{ $li->mata_kuliah->sks }}</td>
                                <td class="text-center">{{ $li->mata_kuliah->semester }}</td>
                                <td class="text-center" style="width: 100px">
                                    <div class="btn-group">
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
