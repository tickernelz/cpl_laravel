@extends('layouts.main')

@section('title')
    {{'Kelola Mata Kuliah'}}
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
                            <div class="card">
                                <div class="card-body">
                                    <a href="{{ Request::url() }}/tambah">
                                        <button type="button"
                                                class="btn btn-primary btn-lg waves-effect waves-light mb-4">Tambah Mata
                                            Kuliah
                                        </button>
                                    </a>
                                    <div class="table-rep-plugin">
                                        <div class="table-responsive mb-0" data-bs-pattern="priority-columns">
                                            <table id="datatable" class="table table-hover table-bordered">
                                                <thead>
                                                <tr>
                                                    <th>Nomor</th>
                                                    <th>Kode Mata Kuliah</th>
                                                    <th>Nama Mata Kuliah</th>
                                                    <th class="text-center">Aksi</th>
                                                </tr>
                                                </thead>

                                                <tbody>
                                                @foreach($mk as $adm)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $adm->kode }}</td>
                                                        <td>{{ $adm->nama }}</td>
                                                        <td class="text-center" style="width: 100px">
                                                            <a href="{{ Request::url() }}/edit/{{ $adm->id }}"
                                                               class="btn btn-secondary btn-sm edit" title="Edit">
                                                                <i class="fas fa-pencil-alt"></i>
                                                            </a>
                                                            <a href="{{ Request::url() }}/hapus/{{ $adm->id }}"
                                                               class="btn btn-secondary btn-sm edit"
                                                               onclick="checkDelete()" title="Delete">
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
            <script type="text/javascript">
                function checkDelete() {
                    return confirm('Apakah Anda Yakin Ingin Menghapus Data ?');
                }
            </script>
@endsection
