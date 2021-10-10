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
        function simpankolom() {
            const nama_kolom = $('input[name="nama_kolom[]"]').map(function () {
                return this.value;
            }).get();
            const urutan = $('input[name="urutan[]"]').map(function () {
                return this.value;
            }).get();
            $.ajax({
                type: "POST",
                url: "{{ URL::to('edit-kolom-cpl') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    id_ta: '{{ Crypt::decrypt(Request::get('tahunajaran')) }}',
                    id_mk: '{{ Crypt::decrypt(Request::get('mk')) }}',
                    id_kelas: '{{ Crypt::decrypt(Request::get('kelas')) }}',
                    semester: '{{ Crypt::decrypt(Request::get('semester')) }}',
                    'nama_kolom[]': nama_kolom,
                    'urutan[]': urutan,
                },
                dataType: 'json',
                success: function (res) {
                    $("#editkolom").modal('hide');
                    location.reload();
                },
                error: function (data) {
                    alert('Gagal Input!')
                    console.log(data);
                }
            });
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
                <form method="GET" action="{{URL::to('kcpl/cari')}}">
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
                                        <label class="form-label" for="mhs">Mahasiswa</label>
                                        <select class="js-select2 form-select" name="mhs" id="mhs">
                                            <option value="{{ Crypt::encrypt('semua') }}">Semua</option>
                                            @foreach($mhs as $item)
                                                <option
                                                    value="{{ Crypt::encrypt($item->id) }}"
                                                    @if (Crypt::decrypt(Request::get('mhs')) === $item->id)
                                                    selected="selected"
                                                    @endif>{{$item->nim}}
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

        <!-- Modal Edit -->
        <div class="modal fade" id="editkolom" tabindex="-1" role="dialog"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="block block-rounded block-themed block-transparent mb-0">
                        <div class="block-header bg-primary-dark">
                            <h3 class="block-title">Edit Urutan Kolom CPL</h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-bs-dismiss="modal"
                                        aria-label="Close">
                                    <i class="fa fa-fw fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content">
                            @foreach($getkolom->sortBy('urutan', SORT_NATURAL) as $li)
                                <div class="mb-3">
                                    <label class="form-label" for="urutan{{ $loop->iteration }}">{{ $li->kode_cpl }}</label>
                                    <input type="hidden" name="nama_kolom[]" value="{{ $li->kode_cpl }}">
                                    <input type="number" name="urutan[]" id="urutan{{ $loop->iteration }}"
                                           class="form-control" value="{{ $li->urutan }}">
                                </div>
                            @endforeach
                        </div>
                        <div class="block-content block-content-full text-end bg-body">
                            <button type="button" class="btn btn-sm btn-alt-secondary" data-bs-dismiss="modal">Tutup
                            </button>
                            <button type="button" id="btn-submit" onclick="simpankolom()"
                                    class="btn btn-sm btn-primary">
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
                    <form method="GET" action="{{route('kcpl-cetak')}}">
                        @csrf
                        <input name="tahun_ajaran" type="hidden"
                               value="{{ Request::get('tahunajaran') }}">
                        <input name="semester" type="hidden"
                               value="{{ Request::get('semester') }}">
                        <input name="mk" type="hidden"
                               value="{{ Request::get('mk') }}">
                        <input name="kelas" type="hidden"
                               value="{{ Request::get('kelas') }}">
                        <input name="mhs" type="hidden"
                               value="{{ Request::get('mhs') }}">
                        <div class="btn-group btn-group-sm" role="group">
                            <button type="submit" class="btn btn-outline-primary">Cetak</button>
                            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                    data-bs-target="#editkolom">Atur Kolom</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="block-content block-content-full">
                @if (Crypt::decrypt(Request::get('mhs')) === 'semua')
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-vcenter js-dataTable-full">
                            <thead>
                            <tr>
                                <th class="text-center" style="width: 50px;">#</th>
                                <th style="width: 80px;">NIM</th>
                                <th style="width: 80px;">Nama Mahasiswa</th>
                                @foreach($getkolom->sortBy('urutan', SORT_NATURAL) as $li)
                                    <th class="text-center">{{ $li->kode_cpl }}</th>
                                @endforeach
                                <th class="text-center">Terakhir Diperbarui</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!$getkolom->isEmpty())
                                @foreach($getmhs as $li)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $li->mahasiswa->nim }}</td>
                                        <td>{{ $li->mahasiswa->nama }}</td>
                                        @foreach($getkolom->sortBy('urutan', SORT_NATURAL) as $lii)
                                            @php
                                                $get_kcpl = $kcpl::where([
                                                    ['mahasiswa_id', '=', $li->mahasiswa->id],
                                                    ['tahun_ajaran_id', '=', Crypt::decrypt(Request::get('tahunajaran'))],
                                                    ['mata_kuliah_id', '=', Crypt::decrypt(Request::get('mk'))],
                                                    ['semester', '=', Crypt::decrypt(Request::get('semester'))],
                                                    ['kode_cpl', '=', $lii->kode_cpl],])
                                                    ->select('*',DB::raw('SUM(bobot_cpl) jumlah_bobot'),DB::raw('SUM(nilai_cpl) jumlah_nilai'))
                                                    ->groupBy('kode_cpl')->get()
                                            @endphp
                                            @foreach($get_kcpl->sortBy('urutan', SORT_NATURAL) as $liii)
                                                @if($get_kcpl->isEmpty())
                                                    <td class="text-center">Kosong!</td>
                                                @else
                                                    <td class="text-center">{{ round(($liii->jumlah_nilai / $liii->jumlah_bobot), 2) }}</td>
                                                @endif
                                            @endforeach
                                        @endforeach
                                        <td class="text-center">{{ $getUpdated->updated_at->diffForHumans() }}</td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-vcenter js-dataTable-full">
                            <thead>
                            <tr>
                                <th class="text-center" style="width: 50px;">#</th>
                                <th style="width: 80px;">NIM</th>
                                <th style="width: 80px;">Nama Mahasiswa</th>
                                @foreach($getkolom->sortBy('kode_cpl', SORT_NATURAL) as $li)
                                    <th class="text-center">{{ $li->kode_cpl }}</th>
                                @endforeach
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($getmhs as $li)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $li->mahasiswa->nim }}</td>
                                    <td>{{ $li->mahasiswa->nama }}</td>
                                    @foreach($getnilai->sortBy('kode_cpl', SORT_NATURAL) as $lii)
                                        <td class="text-center">{{ $lii->average }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
            @endif
            <!-- DataTables init on table by adding .js-dataTable-buttons class, functionality is initialized in js/pages/tables_datatables.js -->

            </div>
        </div>
        <!-- END Dynamic Table with Export Buttons -->
    </div>
    <!-- END Page Content -->
@endsection
