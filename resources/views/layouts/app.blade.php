<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>
        @yield('title') - Sri Lankan Railway
    </title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no'
        name='viewport' />
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <!-- CSS Files -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/paper-dashboard.css?v=2.0.0') }}" rel="stylesheet" />

</head>

<body>
    <div class="wrapper">
        <div class="sidebar" data-color="white" data-active-color="danger">
            <div class="logo">
                {{-- <a href="http://www.creative-tim.com" class="simple-text logo-mini">
                    <div class="logo-image-small">
                        <img src="{{ asset('paper') }}/img/logo-small.png">
                    </div>
                </a> --}}
                <a href="{{ route('dashboard') }}" class="simple-text logo-normal text-center">
                    Sri Lankan Railway
                </a>
            </div>
            <div class="sidebar-wrapper">
                <ul class="nav">
                    <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <a href="{{ route('dashboard') }}">
                            <i class="nc-icon nc-bank"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('employee.*') ? 'active' : '' }}">
                        <a href="{{ route('employee.index') }}">
                            <i class="nc-icon nc-single-02"></i>
                            <p>Employee</p>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('station.*') ? 'active' : '' }}">
                        <a href="{{ route('station.index') }}">
                            <i class="nc-icon nc-map-big"></i>
                            <p>Station</p>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('train.*') ? 'active' : '' }}">
                        <a href="{{ route('train.index') }}">
                            <i class="nc-icon nc-bus-front-12"></i>
                            <p>Train</p>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('route.*') ? 'active' : '' }}">
                        <a href="{{ route('route.index') }}">
                            <i class="nc-icon nc-vector"></i>
                            <p>Route</p>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('schedule.*') ? 'active' : '' }}">
                        <a href="{{ route('schedule.index') }}">
                            <i class="nc-icon nc-bullet-list-67"></i>
                            <p>Schedule</p>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('passenger.*') ? 'active' : '' }}">
                        <a href="{{ route('passenger.index') }}">
                            <i class="nc-icon nc-single-02"></i>
                            <p>Passenger</p>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('forum.*') ? 'active' : '' }}">
                        <a href="{{ route('forum.index') }}">
                            <i class="nc-icon nc-chat-33"></i>
                            <p>Forum</p>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('passenger.*') ? 'active' : '' }}">
                        <a href="{{ route('passenger.index') }}">
                            <i class="nc-icon nc-bell-55"></i>
                            <p>Send Notification</p>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('route.*') ? 'active' : '' }}">
                        <a href="{{ route('route.index') }}">
                            <i class="nc-icon nc-chart-bar-32"></i>
                            <p>Reports</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>


        <div class="main-panel">
            <nav class="navbar navbar-expand-lg navbar-absolute fixed-top navbar-transparent">
                <div class="container-fluid">
                    <div class="navbar-wrapper">
                        <div class="navbar-toggle">
                            <button type="button" class="navbar-toggler">
                                <span class="navbar-toggler-bar bar1"></span>
                                <span class="navbar-toggler-bar bar2"></span>
                                <span class="navbar-toggler-bar bar3"></span>
                            </button>
                        </div>
                        <a class="navbar-brand" href="#pablo">@yield('title')</a>
                    </div>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation"
                        aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-bar navbar-kebab"></span>
                        <span class="navbar-toggler-bar navbar-kebab"></span>
                        <span class="navbar-toggler-bar navbar-kebab"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="navigation">
                        {{-- <form>
                            <div class="input-group no-border">
                                <input type="text" value="" class="form-control" placeholder="Search...">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <i class="nc-icon nc-zoom-split"></i>
                                    </div>
                                </div>
                            </div>
                        </form> --}}
                        <ul class="navbar-nav">
                            {{-- <li class="nav-item">
                                <a class="nav-link btn-magnify" href="#pablo">
                                    <i class="nc-icon nc-layout-11"></i>
                                    <p>
                                        <span class="d-lg-none d-md-block">{{ __('Stats') }}</span>
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item btn-rotate dropdown">
                                <a class="nav-link dropdown-toggle" href="http://example.com"
                                    id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="nc-icon nc-bell-55"></i>
                                    <p>
                                        <span class="d-lg-none d-md-block">{{ __('Some Actions') }}</span>
                                    </p>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                                    <a class="dropdown-item" href="#">{{ __('Action') }}</a>
                                    <a class="dropdown-item" href="#">{{ __('Another action') }}</a>
                                    <a class="dropdown-item" href="#">{{ __('Something else here') }}</a>
                                </div>
                            </li> --}}
                            <li class="nav-item btn-rotate dropdown">
                                <a class="nav-link dropdown-toggle" href="http://example.com"
                                    id="navbarDropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="nc-icon nc-settings-gear-65"></i>
                                    <p>
                                        <span class="d-lg-none d-md-block">Account</span>
                                    </p>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right"
                                    aria-labelledby="navbarDropdownMenuLink2">
                                    <form class="dropdown-item" action="{{ route('logout') }}" id="formLogOut"
                                        method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                    <div class="dropdown-menu dropdown-menu-right"
                                        aria-labelledby="navbarDropdownMenuLink">
                                        <a class="dropdown-item" style="cursor: pointer;"
                                            onclick="document.getElementById('formLogOut').submit();">Log out</a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            @yield('content')
        </div>
    </div>
    <!--   Core JS Files   -->
    <script src="{{ asset('assets/js/core/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/perfect-scrollbar.jquery.min.js') }}"></script>
    <!-- Chart JS -->
    <script src="{{ asset('assets/js/plugins/chartjs.min.js') }}"></script>
    <!--  Notifications Plugin    -->
    <script src="{{ asset('assets/js/plugins/bootstrap-notify.js') }}"></script>
    <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{ asset('assets/js/paper-dashboard.min.js?v=2.0.0') }}" type="text/javascript"></script>

    <script>
        $(document).ready(function() {
            function showNotification(type, message) {
                color = 'primary';
                if (type == 'success') color = 'success';
                if (type == 'error') color = 'danger';
                if (type == 'warning') color = 'warning';
                if (type == 'info') color = 'info';
                $.notify({
                    icon: "nc-icon nc-bell-55",
                    message: message

                }, {
                    type: color,
                    timer: 8000,
                    placement: {
                        from: 'top',
                        align: 'right'
                    }
                });
            }

            @if (session()->has('success'))
                showNotification('success', '{{ session()->get('success') }}');
            @endif

            @if (session()->has('error'))
                showNotification('error', '{{ session()->get('error') }}');
            @endif
        });
    </script>

    @stack('scripts')

</body>

</html>
