@extends('back.master')

@section('content')
    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('home') }}">{{ __('menu.bread.dashboard') }}</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('users.index') }}">{{ __('menu.bread.posts') }}</a>
        </li>
        <li class="breadcrumb-item active">{{ __('menu.bread.create') }}</li>
    </ol>

    <div class="card mb-3">
        <div class="card-header">
            <i class="fas fa-plus"></i>
            {{ __('forms.title.post.create') }}
        </div>
        <div class="card-body row justify-content-center">
            <form id="store-post" method="post" action="{{ route('posts.store') }}" role="form"
                  enctype="multipart/form-data" class="col col-lg-9">

                @csrf

                <div class="row">
                    <div class="form-group col-lg-6">
                        <label for="form_title">{{ __('forms.fields.title') }} *</label>
                        <input id="form_title" type="text" name="name" value="{{ old('title') }}"
                               class="form-control @error('title') is-invalid @enderror"
                               placeholder="{{ __('forms.ph-post.title') }} *">

                        @error('title')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="form_category">{{ __('forms.fields.category') }} *</label>
                        <select id="form_category" class="form-control @error('category') is-invalid @enderror" name="category">
                            <option value="" {{ old('category') ? '' : 'selected' }}></option>
                            @foreach($categories as $category)
                                <option {{ old('category') == $category->name ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-lg-12">
                        <label for="form_tag">{{ __('forms.fields.tags') }}</label>
                        <select id="form_tag" class="form-control @error('tag') is-invalid @enderror" multiple="multiple" name="tag[]">
                            {{--<option value="" {{ old('tag') ? '' : 'selected' }}></option>--}}
                            @foreach($tags as $tag)
                                <option {{ old('tag') == $tag->name ? 'selected' : '' }}>{{ $tag->name }}</option>
                            @endforeach
                        </select>
                        @error('tag')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-12">
                        <label>Image *</label>
                        <div id="post" class="form-control dropzone dz-clickable dropzone-file-area"></div>
                    </div>
                </div>

                <div class="custom-control custom-checkbox my-1 mr-sm-2">

                    <input id="form_active" type="checkbox" name="active" class="custom-control-input">
                    <label class="custom-control-label mr-lg-3"
                           for="form_active">{{ __('forms.fields.active') }}
                    </label>

                    <button type="submit"
                            class="btn btn-primary float-right">{{ __('forms.buttons.add-post') }}
                    </button>

                </div>

            </form>
        </div>
    </div>

@endsection

@section('script')
    @include('back.post.scripts.create')
@endsection