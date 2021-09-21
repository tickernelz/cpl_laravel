@extends('layouts.main')

@section('title')
    {{'Kelola Bobot Teknik Penilaian'}}
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
                                        <form method="get" action="{{URL::to('btp/cari')}}">
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
                                                data-bs-target="#tambahkrs">Tambah
                                            Bobot
                                        </button>
                                        <div class="modal fade" id="tambahkrs" tabindex="-1" role="dialog"
                                             aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-scrollable">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="tambahbobotTitle">
                                                            Tambah Bobot Penilaian</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                    </div>
                                                    <form method="post" action="{{URL::to('btp/post')}}">
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label class="form-label">Kode CPMK</label>
                                                                <input type="text" name="cpmk" id="cpmk"
                                                                       class="form-control" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Teknik Penilaian</label>
                                                                <input type="text" name="teknik" id="teknik"
                                                                       class="form-control" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Kategori</label>
                                                                <select class="form-select" name="kategori"
                                                                        id="kategori">
                                                                    <option value="1">Tugas</option>
                                                                    <option value="2">UTS</option>
                                                                    <option value="3">UAS</option>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Dosen</label>
                                                                <select class="form-select" name="dosen"
                                                                        id="dosen">
                                                                    @foreach($da as $d)
                                                                        <option
                                                                            value="{{ $d->id }}">{{$d->nama}}
                                                                        </option>
                                                                    @endforeach
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
                                                            <button type="submit" id="btn-submit"
                                                                    class="btn btn-primary">
                                                                Simpan
                                                            </button>
                                                        </div>
                                                    </form>
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
                                                        @if ($li->kategori === '1')
                                                            <td>Tugas</td>
                                                        @elseif($li->kategori === '2')
                                                            <td>UTS</td>
                                                        @elseif($li->kategori === '3')
                                                            <td>UTS</td>
                                                        @endif
                                                        <td>{{ $li->bobot }}</td>
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
                <script type="text/javascript">
                    $.ajaxSetup({headers: {'csrftoken': '{{ csrf_token() }}'}});
                </script>
@endsection
