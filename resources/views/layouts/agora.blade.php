<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <title>@yield('title')</title>
    <link rel="icon" type="image/svg" href="{{ asset('admin/assets/images/agora-fav.svg') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="omnya Center" name="description" />

    <!-- App favicon -->
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Bootstrap Css -->
    <link href="{{ asset('admin/assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet"
        type="text/css" />
    <!-- Option 1: Include in HTML -->
    {{-- <link rel="stylesheet" href="{{ asset('site/assets/css/bootstrap-icons.css') }}"> --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" id="app-style"
        rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('admin/assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
</head>

<body data-sidebar="dark" class="sidebar-enable">

    <!-- <body data-layout="horizontal" data-topbar="dark"> -->
    <div id="app">
        <!-- Begin page -->
        <div id="layout-wrapper">


            <header id="page-topbar">
                <div class="navbar-header" style="background: white;color:black;">
                    <div class="d-flex">
                        <!-- LOGO -->
                        <div class="navbar-brand-box blue_bg" style="background-color: white;">
                            <a href="{{ url('dashboard') }}" class="logo logo-dark">
                                <span class="logo-sm">
                                    <img src="{{ asset('admin/assets/logo/omnya/omnyaLogo.jpg') }}" alt="logo-sm-dark"
                                        height="22">
                                </span>
                                <span class="logo-lg">
                                    <img src="{{ asset('/admin/assets/logo/omnya/omnyaLogo.jpg') }}" alt="logo-dark"
                                        height="40">
                                </span>
                            </a>

                            <a href="{{ url('dashboard') }}" class="logo logo-light">
                                <span class="logo-sm">
                                    <img src="{{ asset('admin/assets/logo/omnya/omnyaLogo.jpg') }}" alt="logo-sm-light"
                                        height="40">
                                </span>
                                <span class="logo-lg">
                                    <img src="{{ asset('/admin/assets/logo/omnya/omnyaLogo.jpg') }}" alt="logo-light"
                                        height="40">
                                </span>
                            </a>
                        </div>
                    </div>

                    <div class="d-flex">
                        <div class="dropdown d-inline-block user-dropdown">
                            <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                style="background: white;">
                                <img class="rounded-circle header-profile-user"
                                    src="{{ asset('admin/assets/images/users/Profile.svg') }}" alt="Header Avatar">
                                <span class="d-none d-xl-inline-block ms-1"
                                    style="color: black;">{{ Auth::user()->name }}</span>
                                <i class="mdi mdi-chevron-down d-none d-xl-inline-block" style="color: black;"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->

                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                              document.getElementById('logout-form').submit();"
                                    {{ __('Logout') }}><i class="ri-shut-down-line align-middle me-1 text-danger"></i>
                                    Logout</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                                <router-link to="/changePassword" class="dropdown-item">
                                    <span class="text-black">Change Password</span>
                                </router-link>
                            </div>
                        </div>



                    </div>
                </div>
            </header>


            <div class="vertical-menu sidebar-container" style="background-color: #151f21;">

                <div data-simplebar>

                    <i id="sidebar-toggle" class="bi bi-blockquote-left"
                        style="color: white;float:right;margin-right:10px;font-size:22px;"></i>
                    <!--- Sidemenu -->
                    <div id="sidebar-menu">
                        <!-- Left Menu Start -->
                        <ul class="metismenu list-unstyled" id="side-menu">
                            <li class="menu-title text-menu text-white">Menu</li>

                            <li>
                                <router-link to="/dashboard" class=" waves-effect">
                                    <img src="{{ asset('/admin/assets/images/icons/Dashboard.svg') }}" alt="logo-light"
                                        height="20" class="mr-3">
                                    <span class="text-white">Dashboard</span>
                                </router-link>
                            </li>

                            <li>
                                <router-link to="/addAdmin" class=" waves-effect">
                                    <i class="bi bi-person-badge" style="color:#fcd007 !important"></i></i>
                                    <span class="text-white">Add Admin</span>
                                </router-link>
                            </li>

                            <li>
                                <router-link to="/viewAdmin" class=" waves-effect">
                                    <i class="bi bi-person-lines-fill" style="color:#fcd007 !important"></i>
                                    <span class="text-white">View Admin</span>
                                </router-link>
                            </li>

                            <li>
                                <router-link to="/adduser" class=" waves-effect">
                                    {{-- <img src="{{ asset('/admin/assets/images/icons/person-add.svg') }}"
                                        alt="logo-light" height="20" class="mr-3"> --}}
                                    <i class="bi bi-person-add" style="color:#fcd007 !important"></i></i>
                                    <span class="text-white">Add Apple User</span>
                                </router-link>
                            </li>

                            <li>
                                <router-link to="/viewUser" class=" waves-effect">
                                    <i class="bi bi-person" style="color:#fcd007 !important"></i>
                                    <span class="text-white">View Apple User</span>
                                </router-link>
                            </li>


                            <li>
                                <router-link to="/addcategory" class=" waves-effect">
                                    <i class="bi bi-bar-chart-steps" style="color:#fcd007 !important"></i></i>
                                    <span class="text-white">Add Office</span>
                                </router-link>
                            </li>

                            <li>
                                <router-link to="/viewcategory" class=" waves-effect">
                                    <i class="bi bi-border-style" style="color:#fcd007 !important"></i>
                                    <span class="text-white">View Office</span>
                                </router-link>
                            </li>

                            <li>
                                <router-link to="/import-excel" class=" waves-effect">
                                    <i class="bi bi-file-earmark-spreadsheet" style="color:#fcd007 !important"></i>
                                    <span class="text-white">Import Excel File</span>
                                </router-link>
                            </li>

                            <li>
                                <router-link to="/addgoogleuser" class=" waves-effect">
                                    <i class="bi bi-calendar2-plus" style="color:#fcd007 !important"></i></i>
                                    <span class="text-white">Add Google User</span>
                                </router-link>
                            </li>

                            <li>
                                <router-link to="/viewgoogleusers" class=" waves-effect">
                                    <i class="bi bi-browser-chrome" style="color:#fcd007 !important"></i>
                                    <span class="text-white">View Google Users</span>
                                </router-link>
                            </li>

                            <li>
                                <router-link to="/import-google-excel" class=" waves-effect">
                                    <i class="bi bi-file-earmark-excel" style="color:#fcd007 !important"></i>
                                    <span class="text-white">Import Google Excel File</span>
                                </router-link>
                            </li>


                        </ul>
                    </div>
                    <!-- Sidebar -->
                </div>
            </div>

            <div class="main-content" data-user-id="{{ Auth::user()->id }}">

                <div class="page-content">
                    <div class="container-fluid">





                        <router-view></router-view>
                        <vue-progress-bar></vue-progress-bar>


                        <!-- end row -->


                        <!-- end row -->
                    </div>

                </div>
                <!-- End Page-content -->

                {{-- <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-6">

                            </div>
                            <div class="col-sm-6">
                                <div class="text-sm-end d-none d-sm-block">
                                    Crafted with <i class="mdi mdi-heart" style="color:#2cd98d !important;"></i> by
                                    Orbital Technologies
                                </div>
                            </div>
                        </div>
                    </div>
                </footer> --}}

            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarContainer = document.querySelector('.sidebar-container');
            const sidebarToggle = document.querySelector('#sidebar-toggle');
            const mainContent = document.querySelector('.main-content');

            sidebarToggle.addEventListener('click', function() {
                sidebarContainer.classList.toggle('sidebar-collapsed');
                mainContent.classList.toggle('main-content-collapsed');
            });

            // Trigger the sidebar toggle on page load
            sidebarToggle.click();
        });
    </script>

    <style>
        .sidebar-collapsed .metismenu li span.text-white {
            display: none;
        }

        .sidebar-container {
            /* Your existing styles for the sidebar container */
        }

        .sidebar-collapsed {
            width: 100px;
            /* Adjust this width as needed */
        }

        .main-content {
            margin-left: 240px;
            /* Adjust this margin-leftt as needed */
            /* Your other main content styles */
        }

        .main-content-collapsed {
            margin-left: 100px;
            /* Adjust this margin-leftt as needed when sidebar is collapsed */
        }

        @media (max-width: 992px) {
            .sidebar-container {
                width: 100px !important;
                /* Display the sidebar at full width */
            }

            .main-content {
                margin-left: 100px !important;
                /* Remove the margin to expand the content */
            }
        }
    </style>

    <!-- JAVASCRIPT -->
    <script src="{{ asset('admin/assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('admin/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>


</body>

</html>

<style>
    #sidebar-menu .router-link-exact-active {
        background-color: #004a8f !important;
    }

    #sidebar-menu .router-link-active {
        background-color: #004a8f !important;
    }
</style>
