<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Curriculum vita</title>

    <link href="{{ asset('admin/vendor/bootstrap/css/bootstrap.css') }}" rel="stylesheet" type="text/css">

    <!-- Custom fonts for this template-->
    <link href="{{ asset('admin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">

    <!-- Page level plugin CSS-->
    <link href="{{ asset('admin/vendor/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/vendor/dropzone/dropzone_cv.css') }}" rel="stylesheet">

    {{--<link href="{{ asset('admin/vendor/awesome-bootstrap-checkbox.css') }}" rel="stylesheet">--}}
    <!-- Custom styles for this template-->
    <link href="{{ asset('admin/css/sb-admin.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">


</head>

<body id="page-top">

@include('back.navbar')

<div id="wrapper">

    @include('back.sidebar')

    <div id="content-wrapper">

        <div class="container-fluid">

            <!-- Page Content -->
            @yield('content')

        </div>
        <!-- /.container-fluid -->

        <!-- Sticky Footer -->
        <footer class="sticky-footer">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright © Curriculum vita 2019</span>
                </div>
            </div>
        </footer>

    </div>
    <!-- /.content-wrapper -->

</div>
<!-- /#wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- The Modal -->
<div class="modal fade" id="myModal">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript-->
<script src="{{ asset('admin/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- Core plugin JavaScript-->
{{--<script src="{{ asset('admin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>--}}

<!-- Page level plugin JavaScript-->
<script src="{{ asset('admin/vendor/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('admin/vendor/datatables/dataTables.bootstrap4.js') }}"></script>
<script src="{{ asset('admin/vendor/dropzone/dropzone.js') }}"></script>
<script src="{{ asset('admin/vendor/sweetalert.min.js') }}"></script>
<script src="{{ asset('admin/js/cv.js') }}"></script>

<!-- Custom scripts for all pages-->
<script src="{{ asset('admin/js/sb-admin.min.js') }}"></script>

@yield('script')

</body>

</html>
