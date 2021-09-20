{{
    $getUsername = \App\Http\Controllers\GetController::getNama()
}}
<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="/" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{asset('assets/images/logo-upr.png')}}" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{asset('assets/images/logo-upr.png')}}" alt="" height="17">
                    </span>
                </a>

                <a href="/" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{asset('assets/images/logo-upr.png')}}" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{asset('assets/images/logo-upr.png')}}" alt="" height="60">
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
                <i class="mdi mdi-menu"></i>
            </button>

            <div class="d-none d-sm-block">
                <div class="pt-4 d-inline-block">
                    <h5>Hallo, {{ $getUsername }}</h5>
                </div>
            </div>
        </div>

        <div class="d-flex">

            <div class="dropdown d-none d-lg-inline-block">
                <button type="button" class="btn header-item noti-icon waves-effect" data-bs-toggle="fullscreen">
                    <i class="mdi mdi-fullscreen"></i>
                </button>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="{{asset('assets/images/users/user-4.jpg')}}"
                         alt="Header Avatar">
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <a class="dropdown-item" href="#"><i
                            class="mdi mdi-account-circle font-size-17 align-middle me-1"></i> Profil</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="{{ route('logout') }}"><i
                            class="bx bx-power-off font-size-17 align-middle me-1 text-danger"></i> Logout</a>
                </div>
            </div>

        </div>
    </div>
</header>
