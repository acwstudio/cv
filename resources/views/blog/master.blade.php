<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-100">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Andrey Voskresenskiy">

    <title>Curriculum vita</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('blog/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="{{ asset('blog/css/blog-home.css') }}" rel="stylesheet">

</head>

<body>

@include('blog.navbar')

<!-- Page Content -->
<div class="container">

    <div class="row">

        {{--<!-- Blog Entries Column -->--}}
        <div class="col-md-8">

            <h1 class="my-4">{{ __('blog.title') }}
                <small>{{ __('blog.subtitle') }}</small>
            </h1>

            @yield('content')

        </div>

        @include('blog.sidebar')

    </div>
    <!-- /.row -->

</div>
<!-- /.container -->

<!-- Footer -->
<footer class="py-5 bg-dark">
    <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; Your Website 2019</p>
    </div>
    <!-- /.container -->
</footer>

<!-- Bootstrap core JavaScript -->
<script src="{{ asset('blog/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('blog/vendor/bootstrap/js/bootstrap.min.js') }}"></script>

</body>

</html>
