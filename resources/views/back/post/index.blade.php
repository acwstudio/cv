@extends('back.master')

@section('content')
    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('home') }}">{{ __('menu.bread.dashboard') }}</a>
        </li>
        <li class="breadcrumb-item active">{{ __('menu.bread.posts') }}</li>
    </ol>

    <!-- DataTables Example -->
    <div class="card mb-3">
        <div class="card-header">
            <i class="fas fa-list"></i>
            {{ __('tables.titleTable.posts') }}
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="dataTable" class="table table-bordered table-hover" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>{{ __('tables.fields.id') }}</th>
                        <th>{{ __('tables.fields.author') }}</th>
                        <th>{{ __('tables.fields.title') }}</th>
                        <th>{{ __('tables.fields.body') }}</th>
                        <th>{{ __('tables.fields.category') }}</th>
                        <th>{{ __('tables.fields.tags') }}</th>
                        <th>{{ __('tables.fields.active') }}</th>
                        <th>{{ __('tables.fields.action') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($posts as $post)
                        <tr>
                            <td>{{ $post->id }}</td>
                            {{--<td>{{ $post->r_user->name }}</td>--}}
                            <td>{{ $post->user->name }}</td>
                            <td>{{ $post->title }}</td>
                            <td>{{ $post->body }}</td>
                            <td>
                                <span class="badge badge-pill badge-light">{{ $post->category->name }}</span>
                            </td>
                            <td>
                            @foreach($post->tags as $tag)
                            <span class="badge badge-pill badge-dark">{{ $tag->name }}</span>
                            @endforeach
                            </td>
                            <td>
                                <div class="form-check abc-checkbox abc-checkbox-info">
                                    <input class="form-check-input" id="{{ $post->id }}" type="checkbox"
                                            {{ $post->active === 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="{{ $post->id }}"></label>
                                </div>
                            </td>
                            <td>
                                <a href="#" class="btn btn-outline-info btn-sm mb-1">
                                    <i class="fa fa-info fa-fw"></i>
                                </a>
                                <a href="#" class="btn btn-outline-warning btn-sm mb-1">
                                    <i class="fa fa-pencil-alt fa-fw"></i>
                                </a>
                                <span class="{{ $post->isAdmin ? '' : "isdisabled" }}">
                                    <a href="#" class="btn btn-outline-danger btn-sm">
                                    <i class="fa fa-trash-alt fa-fw"></i>
                                </a>
                                </span>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
@section('script')
    @include('back.post.script')
@endsection