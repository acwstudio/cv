@extends('back.master')

@section('content')
    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">{{ __('menu.bread.dashboard') }}</li>
    </ol>

    <main role="main" class="container">
        <div class="jumbotron">
            <h1 class="display-4">{{ __('forms.jumbotron-user.title') }} {{ $user }}!</h1>
            <p class="lead">{{ __('forms.jumbotron-user.lead') }}</p>
            <hr class="my-4">
            <p>{{ __('forms.jumbotron-user.text') }}</p>
            <a class="btn btn-primary btn-lg" href="{{ route('posts.create') }}" role="button">{{ __('forms.jumbotron-user.button') }}</a>
        </div>
    </main>

@endsection