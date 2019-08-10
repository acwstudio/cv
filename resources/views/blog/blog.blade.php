@extends('blog.master')

@section('content')
    <!-- Blog Entries Column -->

    @foreach($posts as $post)
        <div class="card mb-4">
            <img class="card-img-top" src="{{ $post->image_path }}" alt="Card image cap">
            <div class="card-body">
                <h2 class="card-title">{{ $post->title }}</h2>
                <i class="fas fa-tags"></i>
                @foreach($post->tags as $tag)
                    <span class="badge badge-dark">{{ $tag->name }}</span>
                @endforeach
                <i class="fas fa-folder-open text-info"></i>
                <span class="badge badge-info">{{ $post->category->name }}</span>
                <p class="card-text">{!! $post->body !!}</p>
                <a href="{{ route('post', $post->id) }}" class="btn btn-outline-info">{{ __('blog.more') }} &rarr;</a>
            </div>
            <div class="card-footer text-muted">

                {{ $post->created }}
                {{ __('blog.author') }}
                {{ $post->user->name }}
            </div>
        </div>

    @endforeach

    <div class="mt-5 mb-5">
    {{ $posts->links() }}
    </div>

@endsection