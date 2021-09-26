@extends('layouts.main')

@section('title')
    {{'Kelola Nilai'}}
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
                                        <form method="get" action="{{URL::to('nilai/cari')}}">
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
                                    <div class="table-rep-plugin">
                                        <div class="table-responsive mb-0" data-bs-pattern="priority-columns">
                                            <table id="datatableNilai"
                                                   class="table table-sm table-hover table-bordered">
                                                <thead>
                                                <tr>
                                                    <th>Nomor</th>
                                                    <th>NIM</th>
                                                    <th>Nama Mahasiswa</th>
                                                    @foreach($teknik as $li)
                                                        @if(empty($li->id))
                                                            <th></th>
                                                        @else
                                                            <th class="text-center">{{ $li->nama }}</th>
                                                        @endif
                                                    @endforeach
                                                </tr>
                                                </thead>

                                                <tbody>
                                                @foreach($mhs as $li)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $li->mahasiswa->nim }}</td>
                                                        <td>{{ $li->mahasiswa->nama }}</td>
                                                        @foreach($teknik as $t)
                                                            @if(empty($t->id))
                                                                <td class="teknik"></td>
                                                            @else
                                                                <td class="teknik">
                                                                    <form method="POST"
                                                                          action="{{URL::to('nilai-post')}}">
                                                                        @csrf
                                                                        <div class="input-group mb-3">
                                                                            <input name="mahasiswa_id" type="hidden"
                                                                                   value="{{ $li->mahasiswa->id }}">
                                                                            <input name="btp_id" type="hidden"
                                                                                   value="{{ $t->id }}">
                                                                            <input type="text" name="nilai"
                                                                                   value="{{ \App\Models\Nilai::where([
                                                            ['mahasiswa_id', '=', $li->mahasiswa->id],
                                                            ['btp_id', '=', $t->id],
                                                        ])->value('nilai')}}"
                                                                                   class="form-control"
                                                                                   placeholder="Isi Nilai">
                                                                            <div class="input-group-append">
                                                                                <button
                                                                                    class="btn btn-outline-primary waves-effect waves-light"
                                                                                    type="submit">
                                                                                    Simpan
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </td>
                                                            @endif
                                                        @endforeach
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
@endsection
