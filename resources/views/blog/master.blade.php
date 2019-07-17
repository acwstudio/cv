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

        <!-- Sidebar Widgets Column -->
        <div class="col-md-4">

            <!-- Search Widget -->
            <div class="card my-4">
                <h5 class="card-header">{{ __('sidebar.search') }}</h5>
                <div class="card-body">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="{{ __('sidebar.ph_search') }}...">
                        <span class="input-group-btn">
                <button class="btn btn-secondary" type="button">{{ __('sidebar.go') }}!</button>
              </span>
                    </div>
                </div>
            </div>

            <!-- Categories Widget -->
            <div class="card my-4">
                <h5 class="card-header">{{ __('sidebar.categories') }}</h5>
                <div class="card-body">
                    <div class="row">

                        <ul class="list-unstyled mb-0 ml-lg-5">
                            @foreach($posts->s_categories as $category)
                                <li>
                                    <a href="#">{{ $category->name }}</a>
                                </li>
                            @endforeach
                        </ul>

                    </div>
                </div>
            </div>

            <!-- Side Widget -->
            <div class="card my-4">
                <h5 class="card-header">{{ __('sidebar.tags') }}</h5>
                <div class="card-body">
                    @foreach($posts->s_tags as $tag)
                        <span class="badge badge-pill badge-dark">{{ $tag->name }}</span>
                        @endforeach
                </div>
            </div>

        </div>

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
