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
    <link rel="stylesheet" href=" {{ url('/assets/plugins/jvectormap/jquery-jvectormap-1.2.2.css') }}">

    <link rel="stylesheet" href=" {{ url('/assets/plugins/sweetalert/sweetalert.css') }}">
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
    <div class="wrapper">

      <header class="main-header">
        <!-- Logo -->
        <a href="{{ url('/') }}" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini">HRM</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg">DKGF HRM</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <div class="navbar-custom-menu">
             <ul class="nav navbar-nav">
                <!-- Tasks: style can be found in dropdown.less -->
              <li class="dropdown tasks-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-flag-o"></i>
                  <span class="label label-danger taskHeader"></span>
                </a>
                <ul class="dropdown-menu">
                  <li class="header">You have <span class="taskHeader"></span> tasks</li>
                  <li>
                    <!-- inner menu: contains the actual data -->
                    <ul class="menu taskList">
                                           
                    </ul>
                  </li>
                  <li class="footer">
                    <a href="{{ url('/task') }}"><h5>View all tasks</h5></a>
                  </li>
                </ul>
              </li>
              
              <!-- Control Sidebar Toggle Button -->
              <li>
                <a href="{{ url('logout') }}" >
                 {{ Auth::user()->name, 'User' }}(Logout)
                </a>
              </li>

          </div>
        </nav>
      </header>

      <!-- =============================================== -->

      <!-- Left side column. contains the sidebar -->

     
       
           @yield('sidebar')
        

      <!-- =============================================== -->

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          
          <div class="row">
            @yield('heading')
          </div>
          <h3>
          <div class="row">
            
            <div class="col-sm-6">@yield('page_heading') </div>
            <div class="col-sm-6">@yield('extra_heading') </div>
          </div>
               
          </h3>
          
        </section>

        <!-- Main content -->
        <section class="content">

          
              @yield('content')
          

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

      <footer class="main-footer">
        <div class="pull-right hidden-xs">
         
        </div>
        <strong>Copyright &copy; 2016 <a href="http://universalit.com.bd">Universal IT </a>.</strong> All Rights Reserved
      </footer>

      
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class="control-sidebar-bg"></div>
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
    
    <!-- JQuery Form Validation -->

    <script src="{{ asset('/assets/plugins/jQueryFormValidation/jquery.validate.min.js') }}"></script>
    
    <script src="{{ asset('/assets/js/my.js') }}"></script>

    {{-- Custom Script --}}
     @yield('script')

   <script>
      Laravel = {
          _token: '{{ csrf_token() }}'
      };
  </script>

  {!! Rapyd::scripts() !!}

  <span id="base_url" class="hidden">{{ url() }}</span>

  </body>
</html>
