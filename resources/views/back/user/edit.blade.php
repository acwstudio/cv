@extends('back.master')

@section('content')
    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('home') }}">{{ __('menu.bread.dashboard') }}</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('users.index') }}">{{ __('menu.bread.users') }}</a>
        </li>
        <li class="breadcrumb-item active">{{ __('menu.bread.create') }}</li>
    </ol>

    <!-- DataTables Example -->
    <div class="card mb-3">
        <div class="card-header">
            <i class="fas fa-pencil-alt"></i>
            {{ __('forms.title.user.edit') }}
        </div>
        <div class="card-body row justify-content-center">
            {{--<div class="container">--}}
                <form id="edit-user" method="post" action="{{ route('users.update', $user->id) }}" role="form"
                      enctype="multipart/form-data" class="col col-lg-9">

                    @csrf
                    {{ method_field('PATCH') }}

                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label for="form_name">{{ __('forms.fields.name') }} *</label>
                            <input id="form_name" type="text" name="name" value="{{ $user->name }}"
                                   class="form-control @error('name') is-invalid @enderror"
                                   placeholder="{{ __('forms.ph-user.name') }} *" >

                            @error('name')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="form_email">{{ __('forms.fields.email') }} *</label>
                            <input id="form_email" type="email" name="email" value="{{ $user->email }}"
                                   class="form-control @error('email') is-invalid @enderror"
                                   placeholder="{{ __('forms.ph-user.email') }} *" disabled>

                            @error('email')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label for="form_password">{{ __('forms.fields.password') }} *</label>
                            <input id="form_password" type="text" name="password" value="{{ old('password') }}"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="{{ __('forms.ph-user.password') }} *" disabled>

                            @error('password')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="form_role">{{ __('forms.fields.role') }}</label>
                            <select id="form_role" class="form-control @error('role') is-invalid @enderror" name="role">
                                <option value="" {{ old('role') ? '' : 'selected' }}>Please select</option>
                                @foreach($roles as $role)
                                    <option {{ $user->u_role == $role->name ? 'selected' : '' }}>{{ $role->name }}</option>
                                @endforeach
                            </select>
                            @error('role')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label>{{ __('forms.fields.image') }} *</label>
                            <div id="user" class="form-control dropzone dz-clickable dropzone-file-area"></div>
                        </div>
                    </div>

                    <div class="custom-control custom-checkbox my-1 mr-sm-2">

                        <input id="form_active" type="checkbox" name="active" class="custom-control-input"
                        {{ $user->active ? 'checked' : '' }}>
                        <label class="custom-control-label mr-lg-3"
                               for="form_active">{{ __('forms.fields.active') }}</label>

                        <button type="submit"
                                class="btn btn-primary float-right">{{ __('forms.buttons.update-user') }}</button>

                    </div>

                </form>
            {{--</div>--}}
        </div>
    </div>

@endsection

@section('script')
    @include('back.user.scripts.edit')
@endsection