@php $locale = session()->get('locale'); @endphp
<header id="header" class="navbar navbar-expand-lg navbar-fixed navbar-height navbar-container navbar-bordered bg-white">
    <div class="navbar-nav-wrap">
        <!-- Logo -->
        <a class="navbar-brand" href="#" aria-label="Front">
            <img class="navbar-brand-logo" src="{{ asset('assets/logos/text.png') }}" alt="Logo" data-hs-theme-appearance="default">
            <img class="navbar-brand-logo" src="{{ asset('assets/logos/text.png') }}" alt="Logo" data-hs-theme-appearance="dark">
            <img class="navbar-brand-logo-mini" src="{{ asset('assets/logos/logo.png') }}" alt="Logo" data-hs-theme-appearance="default">
            <img class="navbar-brand-logo-mini" src="{{ asset('assets/logos/logo.png') }}" alt="Logo" data-hs-theme-appearance="dark">
        </a>
        <!-- End Logo -->

        <div class="navbar-nav-wrap-content-start">
            <!-- Navbar Vertical Toggle -->
            <button type="button" class="js-navbar-vertical-aside-toggle-invoker navbar-aside-toggler">
                <i class="bi-arrow-bar-left navbar-toggler-short-align" data-bs-template='<div class="tooltip d-none d-md-block" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>' data-bs-toggle="tooltip" data-bs-placement="right" title="Collapse"></i>
                <i class="bi-arrow-bar-right navbar-toggler-full-align" data-bs-template='<div class="tooltip d-none d-md-block" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>' data-bs-toggle="tooltip" data-bs-placement="right" title="Expand"></i>
            </button>

            <!-- End Navbar Vertical Toggle -->
        </div>

        <div class="navbar-nav-wrap-content-end">
            <!-- Navbar -->
            <ul class="navbar-nav">
{{--                <li class="nav-item d-none d-sm-inline-block mr-4">--}}
{{--                    <div class="d-flex">--}}
{{--                        <div class="flex-grow-1 ms-3">--}}
{{--                          <span class="d-block dolar">$ 18.25</span>--}}
{{--                          <small class="d-block small fecha_dolar">Saldo</small>--}}
{{--                        </div>--}}

{{--                    </div>--}}
{{--                </li>--}}
{{--                <li class="nav-item d-none d-sm-inline-block">--}}
{{--                    <!-- Notification -->--}}
{{--                    <div class="dropdown">--}}
{{--                        <button type="button" class="btn btn-ghost-secondary btn-icon rounded-circle" id="navbarNotificationsDropdown" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside" data-bs-dropdown-animation>--}}
{{--                            <i class="bi-bell"></i>--}}
{{--                            <span class="btn-status btn-sm-status btn-status-danger" id="status_notificacion"></span>--}}
{{--                        </button>--}}

{{--                        <div class="dropdown-menu dropdown-menu-end dropdown-card navbar-dropdown-menu navbar-dropdown-menu-borderless" aria-labelledby="navbarNotificationsDropdown" style="width: 25rem;">--}}
{{--                            <div class="card">--}}
{{--                                <div class="card-header card-header-content-between">--}}
{{--                                    <h4 class="card-title mb-0">Notificaciones</h4>--}}
{{--                                </div>--}}
{{--                                <div class="card-body-height">--}}
{{--                                    <ul class="list-group list-group-flush navbar-card-list-group nav_notifications">--}}
{{--                                        <h5 id="no_notificaciones" class="m-3">No hay notificaciones</h5>--}}
{{--                                    </ul>--}}
{{--                                    <div class="text-center" id="spinnerNList">--}}
{{--                                        <div class="spinner-border text-primary spinner-border-sm" style="width: 3rem; height: 3rem;" role="status" >--}}
{{--                                            <span class="sr-only">Loading...</span>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </li>--}}

                <li class="nav-item">
                    <!-- Account -->
                    <div class="dropdown">
                        <a class="navbar-dropdown-account-wrapper" href="javascript:;" id="accountNavbarDropdown" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside" data-bs-dropdown-animation>
                           <span class="avatar avatar-sm avatar-primary avatar-circle">
                                <span class="avatar-initials">{{ Auth::user()->name[0] }}</span>
                           </span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-end navbar-dropdown-menu navbar-dropdown-menu-borderless navbar-dropdown-account" aria-labelledby="accountNavbarDropdown" style="width: 16rem;">
                            <div class="dropdown-item-text">
                                <div class="flex-grow-1">
                                    <h5 class="mb-0">{{ Auth::user()->name .' ' .Auth::user()->apellidos }}</h5>
                                    <p class="card-text text-body">{{ Auth::user()->email }}</p>
                                </div>
                            </div>

                            <div class="dropdown-divider"></div>

                            <a class="dropdown-item" href="{{ route('perfil.index') }}">Perfil</a>

                            <div class="dropdown-divider"></div>



                            <form class="logout" method="POST" action="{{ route('logout') }}">
                                    @csrf
                                <a class="dropdown-item" onclick="event.preventDefault(); localStorage.clear();;
                                        this.closest('.logout').submit();">
                                    Cerrar sesión
                                </a>

                            </form>
                        </div>
                    </div>
                    <!-- End Account -->
                </li>
            </ul>
            <!-- End Navbar -->
        </div>
    </div>
</header>
