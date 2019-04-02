<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>System Portal</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="{{ asset("bower_components/AdminLTE/bootstrap/css/bootstrap.min.css")}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset("bower_components/AdminLTE/dist/css/AdminLTE.min.css")}}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ asset("bower_components/AdminLTE/dist/css/skins/_all-skins.min.css")}}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset("bower_components/AdminLTE/plugins/iCheck/flat/blue.css")}}">
    <!-- Morris chart --
    <link rel="stylesheet" href="{{ asset("bower_components/AdminLTE/plugins/morris/morris.css")}}">
    <!-- jvectormap --
    <link rel="stylesheet" href="{{ asset("bower_components/AdminLTE/plugins/jvectormap/jquery-jvectormap-1.2.2.css")}}">
    <!-- Date Picker --
    <link rel="stylesheet" href="{{ asset("bower_components/AdminLTE/plugins/datepicker/datepicker3.css")}}">
    <!-- Daterange picker --
    <link rel="stylesheet" href="{{ asset("bower_components/AdminLTE/plugins/daterangepicker/daterangepicker.css")}}">
    <!-- bootstrap wysihtml5 - text editor ->
    <link rel="stylesheet" href="{{ asset("bower_components/AdminLTE/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css")}}">
    <!-- HTML5 Shim and Respond.js IE8 supprt of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work i you view the page via file:// -->
    <!--[if lt IE 9]
    <script src="https://oss.maxcdn.com/htm5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/resond/1.4.2/respond.min.js"></script>
    <![endif]--
    <!-- DataTables --
    <link rel="stylesheet" href="{{ asset("bower_components/AdminLTE/plugins/datatables/dataTables.bootstrap.css")}}">

    <!--progress when saving data css-->
    <link rel="stylesheet" href="{{asset('css/progresspopup.css')}}" >
    <!--progress  when saving data css-->


    <!-- setting the  date  to date field -->
    <link rel="stylesheet" href="{{asset('/datepicker2/css/datepicker.css')}}">
    <script src="datepicker2/js/jquery-1.9.1.min.js"></script>
    <script src="datepicker2/js/bootstrap-datepicker.js"></script>
    <script type="text/javascript">
        // When the document is ready
        $(document).ready(function () {

            $('.inputDate').datepicker({
                maxDate: '1Y',
                autoclose: true,
                dateFormat: "yyyy-mm-dd"

            });


        });



    </script>

    <link rel="stylesheet" href="{{asset('css/iconleft.css')}}" >


</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <!-- Header -->
@include('header')

<!-- Sidebar -->
    @include('sidebar')


    @yield('content')





    @include('footer')

</div>

<!-- jQuery 2.2.3 -->
<script src="{{ asset("bower_components/AdminLTE/plugins/jQuery/jquery-2.2.3.min.js")}}"></script>
<!-- DataTables -->
<script src="{{ asset("bower_components/AdminLTE/plugins/datatables/jquery.dataTables.min.js")}}"></script>
<script src="{{ asset("bower_components/AdminLTE/plugins/datatables/dataTables.bootstrap.min.js")}}"></script>

<script>
    $(function () {
        $("#example1").DataTable();
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false
        });
    });
</script>

<!-- jQuery UI 1.11.4 -->
<script src="{{ asset("bower_components/AdminLTE/https://code.jquery.com/ui/1.11.4/jquery-ui.min.js")}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.6 -->
<script src="{{ asset("bower_components/AdminLTE/bootstrap/js/bootstrap.min.js")}}"></script>
<!-- Morris.js charts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="{{ asset("bower_components/AdminLTE/plugins/morris/morris.min.js")}}"></script>
<!-- Sparkline -->
<script src="{{ asset("bower_components/AdminLTE/plugins/sparkline/jquery.sparkline.min.js")}}"></script>
<!-- jvectormap -->
<script src="{{ asset("bower_components/AdminLTE/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js")}}"></script>
<script src="{{ asset("bower_components/AdminLTE/plugins/jvectormap/jquery-jvectormap-world-mill-en.js")}}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset("bower_components/AdminLTE/plugins/knob/jquery.knob.js")}}"></script>
<!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="{{ asset("bower_components/AdminLTE/plugins/daterangepicker/daterangepicker.js")}}"></script>
<!-- datepicker -->
<script src="{{ asset("bower_components/AdminLTE/plugins/datepicker/bootstrap-datepicker.js")}}"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="{{ asset("bower_components/AdminLTE/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js")}}"></script>
<!-- Slimscroll -->
<script src="{{ asset("bower_components/AdminLTE/plugins/slimScroll/jquery.slimscroll.min.js")}}"></script>
<!-- FastClick -->
<script src="{{ asset("bower_components/AdminLTE/plugins/fastclick/fastclick.js")}}"></script>
<!-- AdminLTE App -->
<script src="{{ asset("bower_components/AdminLTE/dist/js/app.min.js")}}"></script>
<!-- AdminLTE dashboarddemo (This is only for demo purposes) -->
<script src="{{ asset("bower_components/AdminLTE/dist/js/pages/dashboard.js")}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset("bower_components/AdminLTE/dist/js/demo.js")}}"></script>



</body>
</html>
