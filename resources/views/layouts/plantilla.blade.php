<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta content="{{csrf_token()}}" name="csrf-token">
    <title>Sistema de Ventas</title>

    <link rel="stylesheet" href="{{asset('css/plantilla.css')}}">
    <!--include('template.inc.style')-->
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper" id="app">

    <!-- Navbar cabecera -->

        @include('layouts.inc.header')
    <!-- /.navbar cabecera -->
       @include('layouts.inc.menu')
    <!-- Main Sidebar Container menu  -->

    <!-- Main Sidebar Container menu  -->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Dashboard v2</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard v2</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content" id="application">

            <!-- Default box -->
            @yield('contenido')
            <!-- /.card -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <footer class="main-footer">
        <strong>Copyright &copy; 2014-2019 <a href="http://adminlte.io">AdminLTE.io</a>.</strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 3.0.2
        </div>
    </footer>
</div>
<!-- ./wrapper -->


<script src="{{asset('js/app.js')}}"></script>
<script src="{{asset('js/plantilla.js')}}"></script>
<script>
    $('#application').ajaxStart();
    $(document).ajaxComplete(function() {
        Pace.restart()
    });
</script>
<!--include("template.inc.scritp")-->
</body>
</html>
