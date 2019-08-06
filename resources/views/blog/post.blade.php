@extends('blog.master')

@section('content')
    <!-- Blog Entries Column -->
        <div class="card mb-4">
            <img class="card-img-top" src="{{ $postItem->image_path }}" alt="Card image cap">
            <div class="card-body">
                <h2 class="card-title">{{ $postItem->title }}</h2>
                <i class="fas fa-tags"></i>
                @foreach($postItem->tags as $tag)
                    <span class="badge badge-dark">{{ $tag->name }}</span>
                @endforeach
                <i class="fas fa-folder-open text-info"></i>
                <span class="badge badge-info">{{ $postItem->category->name }}</span>
                <p class="card-text">{!! $postItem->body !!}</p>
                {{--<a href="{{ route('post', $post->id) }}" class="btn btn-outline-info">Read More &rarr;</a>--}}
            </div>
            <div class="card-footer text-muted">
                Posted on
                {{ $postItem->created_at->format('j F, Y') }}
                by
                {{ $postItem->user->name }}
            </div>
        </div>

@endsection