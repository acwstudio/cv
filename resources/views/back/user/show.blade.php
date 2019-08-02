<!-- Modal Header -->
<div class="modal-header">
    <h4 class="modal-title">{{ $user->name }}</h4>
    <button type="button" class="close" data-dismiss="modal">&times;</button>
</div>

<!-- Modal body -->
<div class="modal-body">
    <div class="card mb-3">
        <div class="card-header">
            <i class="fas fa-border fa-info"></i>
            {{ __('forms.title.user.show') }}
        </div>
        <div class="card-body row justify-content-center">
            <div class="col-lg-4">
                <img src="{{ $user->image_path }}" height="200px">
            </div>
            <div class="col-lg-8">
                <table class="table">

                    <tr>
                        <td>ID</td>
                        <td>{{$user->id}}</td>
                    </tr>
                    <tr>
                        <td>{{ __('tables.fields.name') }}</td>
                        <td>{{$user->name}}</td>
                    </tr>
                    <tr>
                        <td>{{ __('tables.fields.role') }}</td>
                        <td>{{$user->u_role}}</td>
                    </tr>
                    <tr>
                        <td>{{ __('forms.fields.created') }}</td>
                        <td>{{$user->created_at}}</td>
                    </tr>
                </table>
            </div>

        </div>
    </div>

</div>

<!-- Modal footer -->
<div class="modal-footer">
    <button type="button" class="btn btn-info" data-dismiss="modal">{{ __('forms.buttons.close') }}</button>
</div>