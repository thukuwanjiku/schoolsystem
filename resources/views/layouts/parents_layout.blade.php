
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset("css/bootstrap.min.css") }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('css/ion-icons.min.css') }}">
    <!-- jvectormap -->
    {{--<link rel="stylesheet" href="bower_components/jvectormap/jquery-jvectormap.css">--}}
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/AdminLTE.min.css') }}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ asset('css/all-skins.css') }}">
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery.growl.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style-responsive.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">

    @yield('extra_css')

    <!-- Google Font -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="">

    <header class="main-header" style="position:fixed;width:100%">

        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">

                    @if(session()->has('parent_auth'))
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="tooltip" id="logout-link" title="Hooray!">
                            {{--<img src="dist/img/user2-160x160.jpg" class="user-image" alt="User Image">--}}
                            <span class="hidden-xs">{{ session()->get('parent_auth')->name }}</span>
                        </a>
                        <form action="{{ route('parents_logout') }}" id="logout-form" method="POST">
                            @csrf
                        </form>
                    </li>
                    @endif
                </ul>
            </div>

        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    @include('layouts.parents_side_navigation')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="padding-top: 60px;">
        <!-- Content Header (Page header) -->

        <!-- Main content -->
        <section class="">
            <!-- Info boxes -->

            <!-- Main row -->
            <div class="row">
                <!-- Left col -->
                <div class="col-md-12">
                    <div class="col-sm-12">
                        <h4>@yield('title')</h4>
                    </div>
                    @yield('content')
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

</div>
<!-- ./wrapper -->

<script src="{{ asset('assets/jquery.min.js') }}"></script>
<script src="{{ asset('assets/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/jquery.growl.js') }}"></script>

@if (@$errors->any())
    @foreach ($errors->all() as $error)
        <script>
            $.growl.error({ message: "{!! $error !!}" });
        </script>
    @endforeach
@endif

@if (session('success'))
    <script>
        $.growl.notice({ message: "{!! session('success') !!}" });
    </script>
@endif
@if (session('error'))
    <script>
        $.growl.error({ message: "{!! session('error') !!}" });
    </script>
@endif

@yield('extra_js')

<script>
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
        $("#logout-link").tooltip();

        $("#logout-link").on('click', function () {
            $("form#logout-form").trigger('submit');
        });
    });
</script>

</body>
</html>
