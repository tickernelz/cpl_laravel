<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">

                <li>
                    <a href="{{URL::to('home')}}" class="waves-effect {{ Request::routeIs('home') ? 'active' : '' }}">
                        <i class="ti-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                @role('admin')
                <li>
                    <a href="javascript: void(0);"
                       class="has-arrow waves-effect {{ Request::routeIs('admin','dosen') ? 'active' : '' }}">
                        <i class="mdi mdi-account-supervisor"></i>
                        <span>Admin & Dosen</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{URL::to('admin')}}">Admin</a></li>
                        <li><a href="{{URL::to('dosen')}}">Dosen</a></li>
                    </ul>
                </li>
                <li>
                    <a href="{{URL::to('mhs')}}" class="waves-effect {{ Request::routeIs('mhs') ? 'active' : '' }}">
                        <i class="ti-id-badge"></i>
                        <span>Mahasiswa</span>
                    </a>
                </li>
                <li>
                    <a href="{{URL::to('ta')}}" class="waves-effect {{ Request::routeIs('ta') ? 'active' : '' }}">
                        <i class="ti-calendar"></i>
                        <span>Tahun Ajaran</span>
                    </a>
                </li>
                <li>
                    <a href="{{URL::to('mk')}}" class="waves-effect {{ Request::routeIs('mk') ? 'active' : '' }}">
                        <i class="ti-agenda"></i>
                        <span>Mata Kuliah</span>
                    </a>
                </li>
                <li>
                    <a href="{{URL::to('krs')}}"
                       class="waves-effect {{ Request::routeIs('krs', 'krscari') ? 'active' : '' }}">
                        <i class="ti-notepad"></i>
                        <span>KRS</span>
                    </a>
                </li>
                <li>
                    <a href="{{URL::to('cpl')}}"
                       class="waves-effect {{ Request::routeIs('cpl') ? 'active' : '' }}">
                        <i class="fas fa-book"></i>
                        <span>CPL</span>
                    </a>
                </li>
                @else
                    @endrole
                    @hasanyrole('dosen_koordinator|admin')
                    <li>
                        <a href="{{URL::to('cpmk')}}"
                           class="waves-effect {{ Request::routeIs('cpmk') ? 'active' : '' }}">
                            <i class="ti-book"></i>
                            <span>CPMK</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript: void(0);"
                           class="has-arrow waves-effect {{ Request::routeIs('btp','bcpl') ? 'active' : '' }}">
                            <i class="ti-ruler-pencil"></i>
                            <span>Bobot</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{URL::to('btp')}}">Bobot Teknik Penilaian</a></li>
                            <li><a href="{{URL::to('bcpl')}}">Bobot CPL</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{URL::to('nilai')}}"
                           class="waves-effect {{ Request::routeIs('nilai') ? 'active' : '' }}">
                            <i class="ti-pencil"></i>
                            <span>Nilai</span>
                        </a>
                    </li>
                    @endhasanyrole
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
