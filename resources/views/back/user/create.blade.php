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
            <i class="fas fa-plus"></i>
            {{ __('forms.titleForm.users') }}
        </div>
        <div class="card-body row justify-content-center">
            <form id="store-post" method="post" action="{{ route('users.store') }}" role="form"
                  enctype="multipart/form-data" class="col col-lg-9">

                @csrf

                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="form_name">{{ __('forms.fields.name') }} *</label>
                        <input id="form_name" type="text" name="name" class="form-control"
                               placeholder="{{ __('forms.ph-user.name') }} *">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="form_email">{{ __('forms.fields.email') }} *</label>
                        <input id="form_email" type="text" name="email" class="form-control"
                               placeholder="{{ __('forms.ph-user.email') }} *">
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="form_password">{{ __('forms.fields.password') }} *</label>
                        <input id="form_password" type="text" name="password" class="form-control"
                               placeholder="{{ __('forms.ph-user.password') }} *">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="form_role">{{ __('forms.fields.role') }}</label>
                        <select id="form_role" class="form-control" name="role">
                            <option></option>
                            @foreach($roles as $role)
                                <option>{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-12">
                        <label>Image *</label>
                        <div id="image" class="form-control dropzone dz-clickable dropzone-file-area"></div>
                    </div>
                </div>

                <div class="custom-control custom-checkbox my-1 mr-sm-2">
                    <input id="form_active" type="checkbox" class="custom-control-input">
                    <label class="custom-control-label mr-lg-3"
                           for="form_active">{{ __('forms.fields.active') }}</label>
                    <button type="submit" class="btn btn-primary float-right">{{ __('forms.buttons.add-user') }}</button>
                </div>

            </form>
        </div>
    </div>

@endsection