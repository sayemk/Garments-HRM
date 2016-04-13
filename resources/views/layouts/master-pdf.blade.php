<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" type="image/ico" href="{{ url('favicon.ico') }}"/>
    <title>DKGF @yield('title')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="{{ url('/assets/bootstrap/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('/assets/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('/assets/css/ionicons.min.css') }}">
    <!-- jvectormap -->
    {{--<link rel="stylesheet" href=" {{ url('/assets/plugins/jvectormap/jquery-jvectormap-1.2.2.css') }}">--}}

    {{--<link rel="stylesheet" href=" {{ url('/assets/plugins/sweetalert/sweetalert.css') }}">--}}
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ url('/assets/css/AdminLTE.min.css') }}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ url('/assets/css/skins/_all-skins.min.css') }}">
    <link rel="stylesheet" href="{{ url('/assets/css/style.css') }}">


    {!! Rapyd::styles() !!}
            <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    @yield('css')

</head>
<body class="hold-transition skin-blue sidebar-mini">
<!-- Site wrapper -->








            <!-- =============================================== -->

    <!-- Content Wrapper. Contains page content -->

        <!-- Content Header (Page header) -->


        <!-- Main content -->
        <section class="content">


            @yield('content')


        </section><!-- /.content -->




    <!-- Add the sidebar's background. This div must be placed
         immediately after the control sidebar -->

</div><!-- ./wrapper -->
<!-- jQuery 2.1.4 -->
<script src="{{ url('/assets/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
<!-- Bootstrap 3.3.5 -->
<script src="{{ url('/assets/bootstrap/js/bootstrap.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ url('/assets/plugins/fastclick/fastclick.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ url('/assets/js/app.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ url('/assets/plugins/sparkline/jquery.sparkline.min.js') }}"></script>
<!-- jvectormap -->
<script src="{{ url('/assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
<script src="{{ url('/assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
<!-- SlimScroll 1.3.0 -->
<script src="{{ url('/assets/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
<!-- ChartJS 1.0.1 -->
<script src="{{ url('/assets/plugins/chartjs/Chart.min.js') }}"></script>

<script src="{{ url('/assets/plugins/sweetalert/sweetalert.min.js') }}"></script>

<script src="{{ url('/assets/plugins/momentjs/moment.min.js') }}"></script>

<!-- JQuery Form Validation -->

<script src="{{ asset('/assets/plugins/jQueryFormValidation/jquery.validate.min.js') }}"></script>

<script src="{{ asset('/assets/js/my.js') }}"></script>


</body>
</html>
