<!-- Sidebar Widgets Column -->
<div class="col-md-4">

    <!-- Search Widget -->
    <div class="card my-4">
        <h5 class="card-header">{{ __('sidebar.search') }}</h5>
        <div class="card-body">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="{{ __('sidebar.ph_search') }}...">
                <span class="input-group-btn">
                <button class="btn btn-secondary" type="button">{{ __('sidebar.go') }}!</button>
              </span>
            </div>
        </div>
    </div>

    <!-- Categories Widget -->
    <div class="card my-4">
        <h5 class="card-header">{{ __('sidebar.categories') }}</h5>
        <div class="card-body">
            <div class="row">

                <ul class="list-unstyled mb-0 ml-lg-5">
                    @foreach($posts->s_categories as $category)
                        <li>
                            <a href="#">{{ $category->name }}</a>
                        </li>
                    @endforeach
                </ul>

            </div>
        </div>
    </div>

    <!-- Side Widget -->
    <div class="card my-4">
        <h5 class="card-header">{{ __('sidebar.tags') }}</h5>
        <div class="card-body">
            @foreach($posts->s_tags as $tag)
                <span class="badge badge-pill badge-dark">{{ $tag->name }}</span>
            @endforeach
        </div>
    </div>

</div>