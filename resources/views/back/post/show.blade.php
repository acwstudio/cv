<!-- Modal Header -->
<div class="modal-header">
    <h4 class="modal-title">{{ $postItem->name }}</h4>
    <button type="button" class="close" data-dismiss="modal">&times;</button>
</div>

<!-- Modal body -->
<div class="modal-body">
    <div class="card mb-3">
        <div class="card-header">
            <i class="fas fa-border fa-info"></i>
            {{ __('forms.title.post.show') }}
        </div>
        <div class="card-body row justify-content-center">
            <div class="col-lg-12 text-center ">
                <img src="{{ $postItem->image_path }}" height="200px">
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <table class="table">
                    <tr>
                        <td>ID</td>
                        <td>{{$postItem->id}}</td>
                    </tr>
                    <tr>
                        <td>{{ __('tables.fields.title') }}</td>
                        <td>{{$postItem->title}}</td>
                    </tr>
                    <tr>
                        <td>{{ __('tables.fields.body') }}</td>
                        <td>{{$postItem->body}}</td>
                    </tr>
                    <tr>
                        <td>{{ __('forms.fields.created') }}</td>
                        <td>{{$postItem->created_at}}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

</div>

<!-- Modal footer -->
<div class="modal-footer">
    <button type="button" class="btn btn-info" data-dismiss="modal">{{ __('forms.buttons.close') }}</button>
</div>