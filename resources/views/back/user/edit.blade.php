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
        <div class="card-body">
            {{--<div class="container">--}}
                <form id="edit-user" method="post" action="{{ route('users.store') }}" role="form"
                      enctype="multipart/form-data">

                    @csrf

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="form_name">{{ __('forms.fields.name') }} *</label>
                            <input id="form_name"  type="text" name="name" class="form-control"
                                   placeholder="{{ __('forms.ph-user.name') }} *" required="required">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="form_email">{{ __('forms.fields.email') }} *</label>
                            <input id="form_email"  type="text" name="email" class="form-control"
                                   placeholder="{{ __('forms.ph-user.email') }} *" required="required">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="form_password">{{ __('forms.fields.password') }} *</label>
                            <input id="form_password"  type="text" name="password" class="form-control"
                                   placeholder="{{ __('forms.ph-user.password') }} *" required="required">
                        </div>

                    </div>

                </form>
            {{--</div>--}}
        </div>
    </div>

@endsection