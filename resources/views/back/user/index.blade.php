@extends('back.master')

@section('content')
    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('home') }}">{{ __('menu.bread.dashboard') }}</a>
        </li>
        <li class="breadcrumb-item active">{{ __('menu.bread.users') }}</li>
    </ol>

    <!-- DataTables Example -->
    <div class="card mb-3">
        <div class="card-header">
            <i class="fas fa-list"></i>
            {{ __('tables.titleTable.users') }}
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="dataTable" class="table table-bordered table-hover" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>{{ __('tables.fields.id') }}</th>
                        <th>{{ __('tables.fields.image') }}</th>
                        <th>{{ __('tables.fields.name') }}</th>
                        <th>{{ __('tables.fields.email') }}</th>
                        <th>{{ __('tables.fields.permission') }}</th>
                        <th>{{ __('tables.fields.role') }}</th>
                        <th>{{ __('tables.fields.active') }}</th>
                        <th>{{ __('tables.fields.action') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>
                                <img src="{{ $user->image_path }}" height="100px">
                            </td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @foreach($user->roles as $role)
                                    @foreach($role->permissions as $perm)
                                    <span class="badge badge-pill badge-info">{{ $perm->name }}</span>
                                    @endforeach
                                @endforeach
                            </td>
                            <td>
                                @foreach($user->roles as $role)
                                    <span class="badge badge-pill badge-dark">{{ $role->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                <div class="form-check abc-checkbox abc-checkbox-info">
                                    <input class="form-check-input" id="{{ $user->id }}" type="checkbox"
                                            {{ $user->active === 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="{{ $user->id }}"></label>
                                </div>
                            </td>
                            <td>
                                <a href="#" class="btn btn-outline-info btn-sm mb-1">
                                    <i class="fa fa-info fa-fw"></i>
                                </a>
                                <a href="#" class="btn btn-outline-warning btn-sm mb-1">
                                    <i class="fa fa-pencil-alt fa-fw"></i>
                                </a>
                                <span class="{{ $user->isAdmin ? '' : "isdisabled" }}">
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
    @include('back.user.scripts.index')
@endsection