<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        @include('shared.head-scripts', ['title' => $title ?? 'DEX'])
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">

            <header class="main-header">
                <!-- Logo -->
                <a href="/admin" class="logo">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini"><b>DEX</b></span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg"><b>DEX</b></span>
                </a>
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                        <span class="sr-only">Toggle navigation</span>
                    </a>
                    <!-- Navbar Right Menu -->
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <!-- User Account: style can be found in dropdown.less -->
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                  <!--<img src="dist/img/user2-160x160.jpg" class="user-image" alt="User Image">-->
                                    <span class="hidden-xs">{{ Auth::user()->name }}</span>
                                </a>
                            </li>
                            <!-- Control Sidebar Toggle Button -->
                            <li>
                                <a href="/admin/logout"><i class="fa fa-sign-out"></i></a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            
            <!-- Left side column. contains the logo and sidebar -->
            @yield('left-menu')

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        @yield('title')
                        <!--<small>Version 2.0</small>-->
                    </h1>
                    <ol class="breadcrumb">
                        <li>@yield('balance')</li>
                    </ol>
                </section>
                
                <!-- Main content -->
                <section class="content" id="app">
                    @include('shared.notifications')
                    @yield('content')
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->

            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                    <b>Version</b> 1.0.0
                </div>
                <strong>Copyright &copy; {{ date('Y') }} <a href="#" target="_blank">ABV</a>.</strong> All rights reserved.
            </footer>
        </div>
        <!-- ./wrapper -->

        <script type="text/javascript" src="{{ asset('js/adminlte.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/dataTables.bootstrap.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/main.js') }}" defer></script>
    </body>
</html>
